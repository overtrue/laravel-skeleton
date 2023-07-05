<?php

use App\Admin\Endpoints\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/user', [UserController::class, 'user']);
Route::resource('users', UserController::class);
