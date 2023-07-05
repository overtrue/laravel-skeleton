<?php

namespace App\Api\Auth\Endpoints;

use Domain\User\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;

class Login
{
    use ValidatesRequests;

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    #[ArrayShape(['token_type' => 'string', 'token' => 'string'])]
    public function __invoke(Request $request): array
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'string',
        ]);

        /* @var User $user */
        $user = User::where('username', $request->input('username'))->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);
        }

        return $user->createDeviceToken($request->get('device_name'));
    }
}
