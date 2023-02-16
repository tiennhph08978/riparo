<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Models\Admin;
use App\Services\Admin\AuthService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware($this->authMiddleware())->only(['logout']);
        $this->middleware($this->guestMiddleware())->except(['logout']);
    }

    /**
    * getViewAdminLogin.
    *
    * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
    */
    public function signIn()
    {
        return view('admin.auth.login');
    }

    /**
     * Login
     *
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        $loginData = AuthService::getInstance()->postLogin($request->only(['email', 'password']));
        if ($loginData) {
            $url = $this->getRedirectUrl();

            return redirect($url);
        } else {
            return redirect(route('admin.login'))->withInput();
        }
    }

    /**
     * Logout
     *
     */
    public function logout()
    {
        $this->guard()->logout();

        return redirect(route('admin.login'));
    }

    /**
    * @return string
    */
    private function getRedirectUrl()
    {
        if (Session::has('admin_redirect_url')) {
            $url = Session::get('admin_redirect_url');
            Session::forget('admin_redirect_url');
        } else {
            $url = route('admin.manager-user.index');
        }

        return route('admin.manager-user.index');
    }
}
