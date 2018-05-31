<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role == 'Admin' || Auth::user()->role == 'SuperAdmin')
            return $next($request);
        return redirect('error');
    }
}