<?php

namespace Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AcceptJsonResponse
{
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
