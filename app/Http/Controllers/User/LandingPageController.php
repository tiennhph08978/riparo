<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        //
    }

    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('user.landing_page.index');
    }
}
