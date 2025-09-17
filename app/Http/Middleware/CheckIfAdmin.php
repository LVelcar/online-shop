<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    
    public function handle(Request $request, Closure $next): Response
    {
        // Si no hay usuario logueado o el usuario no es admin, bloqueamos acceso
        if (! $request->user() || ! $request->user()->isAdmin()) {
            abort(403, 'Access denied');
        }

        // Si es admin, continúa con la petición
        return $next($request);
    }

}
