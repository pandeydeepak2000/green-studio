<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->check() || auth()->user()->role !== 'admin') {
            return redirect('/')
                ->with('status', 'Access denied: admin only area.');
        }

        return $next($request);
    }
}