<?php

namespace App\Admin\Endpoints;

use Domain\User\User;

class GetUser
{
    public function __invoke(User $user): User
    {
        return $user;
    }
}
