<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminGuard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ( Auth::user() == null ) {
            return to_route('login');
        }

        if ( Auth::user()->roles->pluck('name')[0] !== 'admin' ) {
            return to_route('web.home.index');
        }

        return $next($request);
    }
}
