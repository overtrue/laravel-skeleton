<?php

namespace App\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Rules\Phone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return User::filter($request->all())
            ->latest()
            ->paginate($request->get('per_page', 20));
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\JsonResource
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

    /**
     * @param  \App\Models\User  $user
     * @return \App\Models\User
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \App\Models\User
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return $user;
    }

    /**
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->noContent();
    }
}
