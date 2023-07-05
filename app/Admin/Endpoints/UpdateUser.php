<?php

namespace App\Admin\Endpoints;

use Domain\User\User;
use Illuminate\Http\Request;

class UpdateUser
{
    public function __invoke(Request $request, User $user): User
    {
        $user->update($request->all());

        return $user;
    }
}
