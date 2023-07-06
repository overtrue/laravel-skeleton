<?php

namespace App\Api;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->group(__DIR__.'/User/routes.php')
            ->group(__DIR__.'/Auth/routes.php');
    }
}
