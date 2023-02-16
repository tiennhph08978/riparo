<?php

namespace App\Services\Admin;

use App\Models\Admin;
use App\Services\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

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
        $remember = isset($data['remember']) ? true : false;

        $admin = Admin::where('email', $data['email'])->first();

        if (!$admin || !Hash::check($data['password'], $admin->password)) {
            throw ValidationException::withMessages(['email' => trans('auth.W002_E001_wrong_password')]);
        }

        return Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']], $remember);
    }

    /**
     * @return User|null
     */
    public function me()
    {
        return $this->user;
    }
}
