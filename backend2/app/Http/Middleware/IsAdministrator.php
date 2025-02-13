<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdministrator
{
    public function handle($request, Closure $next)
    {
        if (auth()->user()->role != 'deputy' && auth()->user()->role != 'administrator') {
            return redirect('/');
        }
    
        return $next($request);
    }
}
