<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class CustomEnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectToRoute
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse|null
     */
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        if (! $request->user() ||
            ($request->user() instanceof MustVerifyEmail &&
            ! $request->user()->hasVerifiedEmail())) {


                if(get_class($request->user()) === 'App\Models\User') { 
                    $path = 'user.';
                } else {
                    $path = 'admin.';
                }
            return $request->expectsJson()
                    ? abort(403, 'Your email address is not verified.')
                    : Redirect::guest(URL::route($redirectToRoute ?: $path. 'verification.notice'));
        }

        return $next($request);
    }
}