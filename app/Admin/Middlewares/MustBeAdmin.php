<?php

namespace App\Admin\Middlewares;

use Closure;
use Illuminate\Http\Request;

class MustBeAdmin
{
    public function handle(Request $request, Closure $next)
    {
        \abort_if(\auth()->guest() || !$request->user()->isAdmin(), 403, '非法访问！');

        return $next($request);
    }
}
