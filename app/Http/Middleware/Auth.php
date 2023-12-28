<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Auth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $path = $request->path();
        $path = Str::replace('sie/', '', $path);

        // echo $path;

        $authenticated = session()->has('user');

        if($path !== 'login' && $path !== '/' && !$authenticated) {
            return redirect('/sie/login');
        } else if($authenticated && ($path === 'login' || $path === '/')) {
            return redirect('/sie/home');
        }

        return $next($request);
    }
}
