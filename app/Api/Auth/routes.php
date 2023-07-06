<?php

use App\Api\Auth\Endpoints;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')
    ->group(function () {
        Route::post('login', Endpoints\Login::class)->name('auth.login');
        Route::post('register', Endpoints\Register::class)->name('auth.register');

        Route::middleware('auth:sanctum')->group(function () {
            Route::post('logout', Endpoints\Logout::class)->name('auth.logout');
        });
    });
