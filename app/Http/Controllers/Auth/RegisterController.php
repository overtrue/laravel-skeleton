<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\ArrayShape;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    #[ArrayShape(['token_type' => "string", 'token' => "string"])]
    public function __invoke(Request $request): array
    {
        $request->validate([
            'username' => 'required|unique:users',
            'password' => 'required',
        ]);

        /* @var \App\Models\User $user */
        $user = User::create($request->all());

        return $user->createDeviceToken($request->get('device_name'));
    }
}
