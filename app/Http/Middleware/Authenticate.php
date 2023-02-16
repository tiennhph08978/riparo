<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Support\Arr;

class Authenticate extends Middleware
{
    protected $guards;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->guards = $guards;

        return parent::handle($request, $next, ...$guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        $segments = $request->segments();
        $currentURL = implode('/', $segments);

        if (Arr::first($this->guards) === 'admin') {
            if (Auth::guard('admin')->guest()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response('Unauthorized.', 401);
                } else {
                    if ($currentURL != 'admin/login') {
                        $request->session()->put('admin_redirect_url', $currentURL);
                    }

                    return route('admin.login');
                }
            }
        }

        if (! $request->expectsJson()) {
            return route('user.auth.login');
        }
    }
}
