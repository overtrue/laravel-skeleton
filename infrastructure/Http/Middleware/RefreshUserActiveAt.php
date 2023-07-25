<?php

namespace Infrastructure\Http\Middleware;

use Closure;
use Domain\User\Jobs\RefreshUserFirstActivedAt;
use Domain\User\Jobs\RefreshUserLastActiveAt;
use Illuminate\Http\Request;

class RefreshUserActiveAt
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (\Auth::hasUser()) {
            \mt_rand(0, 9) > 5 || RefreshUserLastActiveAt::dispatchAfterResponse($request->user());

            if (empty($request->user()->first_active_at)) {
                RefreshUserFirstActivedAt::dispatchAfterResponse($request->user());
            }
        }

        return $next($request);
    }
}
