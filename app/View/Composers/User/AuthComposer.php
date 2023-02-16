<?php

namespace App\View\Composers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthComposer
{
    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('user', Auth::guard('user')->user());
    }
}
