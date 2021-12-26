<?php

use App\Admin\Http\Controllers\SettingController;
use App\Admin\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'user']);
Route::resource('users', UserController::class);
