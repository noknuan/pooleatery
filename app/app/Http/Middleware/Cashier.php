<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Cashier
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role == 'Cashier')
            return $next($request);
        return redirect('error');
    }
}