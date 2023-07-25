<?php

namespace App\Api\User\Endpoints;

use App\Api\User\Resources\User as UserResource;
use Domain\User\User;
use Illuminate\Http\Request;

class GetUser
{
    public function __invoke(Request $request, User $user): UserResource
    {
        return new UserResource($user);
    }
}
