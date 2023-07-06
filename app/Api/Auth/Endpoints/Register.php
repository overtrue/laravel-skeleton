<?php

namespace App\Api\Auth\Endpoints;

use Domain\User\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class Register
{
    use ValidatesRequests;

    public function __invoke(Request $request): array
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        /* @var \Domain\User\User $user */
        $user = User::create($request->all());

        return $user->createDeviceToken($request->get('device_name'));
    }
}
