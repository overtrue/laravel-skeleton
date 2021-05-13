<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use JetBrains\PhpStorm\ArrayShape;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    #[ArrayShape(['token_type' => "string", 'token' => "string"])]
    public function __invoke(Request $request): array
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'device_name' => 'string',
        ]);

        /* @var User $user */
        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);
        }

        return $user->createDeviceToken($request->get('device_name'));
    }
}
