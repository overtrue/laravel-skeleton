<?php

namespace App\Admin\Endpoints;

use Domain\User\Rules\Phone;
use Domain\User\User;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CreateUser
{
    use ValidatesRequests;

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function __invoke(Request $request): User
    {
        $this->validate($request, [
            'name' => 'string|min:5|max:12',
            'username' => 'required|string|min:5|max:12',
            'nickname' => 'required|string',
            'password' => 'required|confirmed|min:6|max:14',
            'gender' => [
                'required',
                Rule::in(['male', 'female']),
            ],
            'phone' => [
                'required',
                'unique:users',
                new Phone(),
            ],
        ]);

        return User::create($request->all());
    }
}
