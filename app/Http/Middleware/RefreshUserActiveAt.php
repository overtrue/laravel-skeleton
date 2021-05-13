<?php

namespace App\Http\Middleware;

use App\Jobs\RefreshUserFirstActivedAt;
use App\Jobs\RefreshUserLastActiveAt;
use Closure;
use Illuminate\Http\Request;

class RefreshUserActiveAt
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (\Auth::check()) {
            \mt_rand(0, 9) > 5 || RefreshUserLastActiveAt::dispatchAfterResponse($request->user());

            if (empty($request->user()->first_active_at)) {
                RefreshUserFirstActivedAt::dispatchAfterResponse($request->user());
            }
        }

        return $next($request);
    }
}
