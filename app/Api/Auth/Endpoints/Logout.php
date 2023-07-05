<?php

namespace App\Api\Auth\Endpoints;

use Illuminate\Http\Request;

class Logout
{
    public function __invoke(Request $request): \Illuminate\Http\Response
    {
        $request->user()->tokens()->delete();

        return \response()->noContent();
    }
}
