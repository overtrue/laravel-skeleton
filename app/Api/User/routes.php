<?php

use App\Api\User\Endpoints;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', Endpoints\GetMe::class)->name('users.me');
    Route::get('/users/{user}', Endpoints\GetUser::class)->name('users.show');
});
