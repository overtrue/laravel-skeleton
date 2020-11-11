<?php

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index']);
