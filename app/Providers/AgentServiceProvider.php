<?php

namespace App\Providers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\BaseController;
use Illuminate\Support\ServiceProvider;

class AgentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $agent = new Agent();

        BaseController::share('agent', $agent);
    }
}
