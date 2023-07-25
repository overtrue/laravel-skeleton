<?php

namespace App\Api\User\Endpoints;

use Domain\User\User;
use Illuminate\Http\Request;

class GetMe
{
    public function __invoke(Request $request): User
    {
        return $request->user();
    }
}
