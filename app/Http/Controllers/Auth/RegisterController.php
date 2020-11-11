<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function __invoke(Request $request)
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
