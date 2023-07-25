<?php

namespace App\Api\Auth\Endpoints;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Logout
{
    public function __invoke(Request $request): Response
    {
        $request->user()->tokens()->delete();

        return \response()->noContent();
    }
}
