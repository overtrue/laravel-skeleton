<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function user(Request $request)
    {
        return $request->user();
    }

    public function show(User $user): User
    {
        $this->authorize('view', $user);

        return $user;
    }
}
