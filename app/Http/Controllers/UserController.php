<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class UserController.
 */
class UserController extends Controller
{
    public function user(Request $request)
    {
        return $request->user();
    }
}
