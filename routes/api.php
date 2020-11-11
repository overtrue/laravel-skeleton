<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/settings', [SettingController::class, 'index']);

Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class);
Route::post('/register', RegisterController::class);

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/user', [UserController::class, 'user']);

    //
});
