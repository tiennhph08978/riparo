<?php

namespace App\Providers\ServiceRegister;

use App\Services\Admin\AuthService;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application;

class Admin
{
    /**
     * Register Admin Service
     *
     * @param Application|Container $app
     * @return void
     */
    public static function register($app)
    {
        $app->scoped(AuthService::class, function ($app) {
            return new AuthService();
        });
    }
}
