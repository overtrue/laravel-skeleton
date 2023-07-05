<?php

use App\Api\Auth\Endpoints\Login;
use App\Api\Auth\Endpoints\Logout;
use App\Api\Auth\Endpoints\Register;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', Login::class);
Route::post('/logout', Logout::class);
Route::post('/register', Register::class);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [UserController::class, 'user']);
    Route::resource('/users', UserController::class);
    //
});
