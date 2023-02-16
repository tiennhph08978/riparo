<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Routing\Controller as BaseController;

class LoginController extends BaseController
{
    public function index()
    {
        return view('user.layouts.login');
    }
}
