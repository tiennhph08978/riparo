<?php

namespace App\Services\User;

use App\Helpers\StringHelper;
use App\Http\Requests\User\Auth\ChangeForgotPasswordRequest;
use App\Jobs\SendForgotPasswordEmail;
use App\Jobs\User\RegisterJob;
use App\Jobs\User\SendEmail;
use App\Models\Email;
use App\Models\User;
use App\Models\UserVerify;
use App\Services\Service;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthService extends Service
{
    /**
     * Login
     *
     * @param array $data
     * @return bool|RedirectResponse
     * @throws ValidationException
     */
    public function postLogin(array $data)
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            throw ValidationException::withMessages(['email' => trans('auth.W002_E001_wrong_password')]);
        }

        if ($user->status == User::STATUS_INACTIVATED) {
            return trans('auth.W001_I001_email_ban');
        }

        return auth()->guard('user')->attempt($data);
    }

    /**
     * @param array $user
     * @return mixed
     */
    public function postRegister(array $user)
    {
        try {
            DB::beginTransaction();
            $user['post_code'] = str_replace(['-', '_', ''], '', $user['post_code']);
            $user['password'] = Hash::make($user['password']);
            $user['status'] = User::STATUS_ACTIVATED;
            $user['city'] = array_search($user['city'], config('master_data.provinces'));

            $userCreate = User::create($user);
            $token = Str::random(64);

            UserVerify::create([
                'user_id' => $userCreate->id,
                'token' => $token,
            ]);
            $mailData = [
                'user' => $userCreate,
                'user_id' => $userCreate->id,
                'first_name' => $userCreate->first_name,
            ];
            $mailTemplate = Email::where('type', Email::TYPE_VERIFY_EMAIL)->first();
            $link = route('user.email.verify', ['id' => $userCreate->id, 'token' => $token]);
            $mailTemplate->content = str_replace('{url}', '<a href="' . $link . '">'. $link .'</a>', $mailTemplate->content);
            dispatch(new SendEmail($userCreate->email, $mailData, $mailTemplate->toArray()))->onQueue(config('queue.email_queue'));
            DB::commit();

            return $userCreate;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param string $email
     * @return mixed
     * @throws ValidationException
     */
    public function forgotPassword(string $email)
    {
        $user = User::where('email', $email)->first();
        $emailTemplate = Email::where('type', Email::TYPE_FORGOT_PASSWORD)->first();
        if (!$user) {
            throw ValidationException::withMessages(['email' => trans('validation.W001_E004_not_register_yet')]);
        } elseif ($user->status === User::STATUS_INACTIVATED) {
            throw ValidationException::withMessages(['email' => trans('auth.W001_I001_email_ban')]);
        }

        try {
            DB::beginTransaction();

            $token = StringHelper::createToken();
            $user->update(['token' => $token]);
            $data = [
                'email' => $email,
                'first_name' => $user->first_name,
                'token' => $token,
            ];
            dispatch(new SendForgotPasswordEmail($data, $emailTemplate))->onQueue(config('queue.email_queue'));
            DB::commit();

            return $user;
        } catch (\Exception $exception) {
            DB::rollBack();
            return null;
        }
    }

    /**
     * @param $email
     * @param $token
     * @return mixed
     */
    public function viewResetPassword($email, $token)
    {
        return User::where('email', $email)->where('token', $token)->first();
    }

    /**
     * @param string $newPassword
     * @param string $email
     * @param string $token
     */
    public function changeForgotPassword(string $newPassword, string $email, string $token)
    {
        $user = User::where('email', $email)->where('token', $token)->first();
        if (!$user) {
            return false;
        }
        try {
            DB::beginTransaction();
            $user = User::find($user->id);
            $user->password = Hash::make($newPassword);
            $user->token = null;
            $user->save();
            DB::commit();

            return $user;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @param string $oldPassword
     * @param string $newPassword
     * @return bool|void
     */
    public function updatePassword(string $oldPassword, string $newPassword)
    {
        try {
            DB::beginTransaction();
            $user = $this->getUser();
            if (Hash::check($oldPassword, $user->password)) {
                return $user->update(['password' => Hash::make($newPassword)]);
            }
            DB::commit();

            return false;
        } catch (\Exception $exception) {
            DB::rollBack();
            return false;
        }
    }

    /**
     * @return User|null
     */
    public function me()
    {
        return $this->user;
    }
}
