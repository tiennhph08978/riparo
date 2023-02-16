<?php

namespace App\Providers;

use App\Providers\ServiceRegister\Admin;
use App\Providers\ServiceRegister\Common;
use App\Providers\ServiceRegister\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Admin::register($this->app);
        User::register($this->app);
        Common::register($this->app);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
    }
}
