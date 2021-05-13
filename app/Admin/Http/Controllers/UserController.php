<?php

namespace App\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Rules\Phone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        return User::filter($request->all())
            ->latest()
            ->paginate($request->get('per_page', 20));
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'string|min:5|max:12',
            'username' => 'required|string|min:5|max:12',
            'real_name' => 'required|string',
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

    public function show(User $user): User
    {
        return $user;
    }

    public function update(Request $request, User $user): User
    {
        $user->update($request->all());

        return $user;
    }

    public function destroy(User $user): \Illuminate\Http\Response
    {
        $user->delete();

        return response()->noContent();
    }
}
