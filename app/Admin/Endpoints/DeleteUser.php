<?php

namespace App\Admin\Endpoints;

use Domain\User\User;
use Illuminate\Http\Response;

class DeleteUser
{
    public function __invoke(User $user): Response
    {
        $user->delete();

        return response()->noContent();
    }
}
