<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Rules\Phone;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\Resource;
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
        $users = User::filter($request->all())
            ->with($request->includes())
            ->latest()
            ->paginate($request->get('per_page', 20));

        return Resource::collection($users);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\Resource
     *
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

        return new Resource(User::create($request->all()));
    }

    /**
     * @param \App\User $user
     *
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function show(User $user)
    {
        return new Resource($user->loadMissing(\request()->includes()));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\User                $user
     *
     * @return \Illuminate\Http\Resources\Json\Resource
     */
    public function update(Request $request, User $user)
    {
        $user->update($request->all());

        return new Resource($user);
    }

    /**
     * @param \App\User $user
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
