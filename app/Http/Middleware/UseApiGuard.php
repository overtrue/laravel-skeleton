<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class UseApiGuard
{
    public function handle(Request $request, Closure $next)
    {
        \Auth::shouldUse('api');

        return $next($request);
    }
}
