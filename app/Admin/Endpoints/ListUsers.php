<?php

namespace App\Admin\Endpoints;

use Domain\User\User;
use Illuminate\Http\Request;

class ListUsers
{
    public function __invoke(Request $request)
    {
        return User::filter($request->all())
            ->latest()
            ->paginate($request->get('per_page', 20));
    }
}
