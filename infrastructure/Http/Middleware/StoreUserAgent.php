<?php

namespace Infrastructure\Http\Middleware;

use Closure;
use Domain\User\UserAgent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StoreUserAgent
{
    public function handle(Request $request, Closure $next): mixed
    {
        if (Auth::check()) {
            $agent = $request->header('User-Agent') ?: 'Unknown';

            $authId = Auth::id();

            dispatch(function () use ($agent, $authId) {
                UserAgent::firstOrCreate(['user_id' => $authId, 'agent' => Str::limit($agent, 500)])->refreshLastUsedAt();
            })->afterResponse();
        }

        return $next($request);
    }
}
