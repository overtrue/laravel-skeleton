<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \App\Http\Resources\UserResource
     */
    public function me(Request $request)
    {
        return new UserResource($request->user());
    }
}
