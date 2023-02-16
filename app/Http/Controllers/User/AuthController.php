<?php

namespace App\Http\Controllers\User;

use App\Http\Requests\User\Auth\ChangeForgotPasswordRequest;
use App\Http\Requests\User\Auth\LoginRequest;
use App\Http\Requests\User\Auth\UpdatePasswordRequest;
use App\Http\Requests\User\ForgotPasswordRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\UserVerify;
use App\Services\User\AuthService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class AuthController extends BaseController
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware($this->authMiddleware())->only(['updatePassword', 'logout']);
        $this->middleware($this->guestMiddleware())->except(['updatePassword', 'logout']);
    }

    /**
     * Login
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function login()
    {
        return view('user.auth.login');
    }

    /**
     * Post Login
     *
     * @param LoginRequest $request
     * @return Application|Factory|View|RedirectResponse
     * @throws ValidationException
     */
    public function postLogin(LoginRequest $request)
    {
        $loginData = AuthService::getInstance()->postLogin($request->only(['email', 'password']));

        if ($loginData === true) {
            if ($request->get('next_page_url')) {
                return redirect()->to($request->get('next_page_url'));
            }
            if (str_contains(redirect()->intended()->getTargetUrl(), url('/admin'))) {
                return redirect()->route('user.index');
            }

            return redirect()->intended();
        }

        return redirect()->back()->with('error', $loginData);
    }

    public function register()
    {
        return view('user.auth.register');
    }

    /**
     * @param RegisterRequest $request
     * @return RedirectResponse
     */
    public function postRegister(RegisterRequest $request)
    {
        $user = $request->only([
            'first_name',
            'first_name_furigana',
            'last_name',
            'last_name_furigana',
            'email',
            'password',
            'phone_number',
            'post_code',
            'city',
            'address',
        ]);

        AuthService::getInstance()->postRegister($user);

        return redirect()->route('user.auth.login')->with('success', trans('message.success_register'));
    }

    /**
     * @return Application|Factory|View
     */
    public function getForgotPassword()
    {
        return view('user.auth.forgot-password');
    }

    /**
     * @return View
     */
    public function getForgotPasswordLink(Request $request)
    {
        $email = $request->email;

        return view('user.auth.forgot-password-link', compact('email'));
    }

    /**
     * forgotPassword
     *
     * @param ForgotPasswordRequest $request
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $emailRequest = $request->get('email');
        AuthService::getInstance()->forgotPassword($emailRequest);

        return redirect()->route('user.auth.forgot_password_link', ['email' => $emailRequest])->with(trans('message.success'));
    }

    /**
     * getViewPassword
     *
     */
    public function getViewPassword(Request $request)
    {
        $email = $request->get('email');
        $token = $request->get('token');
        $userEmail = AuthService::getInstance()->viewResetPassword($email, $token);
        $data = [
            'email' => $email,
            'token' => $token,
        ];
        if ($userEmail) {
            return view('user.auth.change-forgot-password', $data);
        }

        return redirect()->route('user.auth.login');
    }

    /**
     * changeForgotPassword
     *
     * @param ChangeForgotPasswordRequest $request
     * @return RedirectResponse
     */
    public function changeForgotPassword(ChangeForgotPasswordRequest $request)
    {
        $newPassword = $request->get('password');
        $email = $request->get('email');
        $token = $request->get('token');
        AuthService::getInstance()->changeForgotPassword($newPassword, $email, $token);

        return redirect()->route('user.auth.login')->with('success', trans('message.success_reset_password'));
    }

    /**
     * updatePassword
     *
     * @param UpdatePasswordRequest $request
     * @return RedirectResponse
     */
    public function updatePassword(UpdatePasswordRequest $request)
    {
        $oldPassword = $request->get('old_password');
        $newPassword = $request->get('new_password');
        $user = $this->guard()->user();
        $result = AuthService::getInstance()->withUser($user)->updatePassword($oldPassword, $newPassword);
        if ($result) {
            return back()->with(trans('message.success'));
        }

        throw ValidationException::withMessages(['old_password' => trans('message.error')]);
    }

    /**
     * Logout
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->back();
    }

    /**
     * Write code on Method
     *
     * @param $id
     * @param $token
     * @return RedirectResponse
     */
    public function verifyAccount($id, $token)
    {
        $verifyUser = UserVerify::where('token', $token)->where('user_id', $id)->first();

        if (!is_null($verifyUser)) {
            $verifyUser->user->email_verified_at = Carbon::now();
            $verifyUser->user->save();
            return redirect()->route('user.auth.login')->with('success', trans('auth.verify_success'));
        }

        return redirect()->route('user.auth.login')->with('error', trans('message.W001_E003_email'));
    }
}
