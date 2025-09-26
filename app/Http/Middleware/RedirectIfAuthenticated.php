<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guards = null)
    {
       if (Auth::guard($guards)->check()) {
           return redirect(RouteServiceProvider::HOME);
       }    
         return $next($request);

    }
}

