<?php

namespace App\Admin;

use App\Admin\Middlewares\MustBeAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Route::prefix('admin')
            ->middleware(['api', 'auth', MustBeAdmin::class])
            ->as('admin.')
            ->group(function () {
                Route::get('/users', Endpoints\ListUsers::class)->name('users.index');
                Route::get('/users/{user}', Endpoints\GetUser::class)->name('users.show');
                Route::put('/users/{user}', Endpoints\UpdateUser::class)->name('users.update');
                Route::delete('/users/{user}', Endpoints\DeleteUser::class)->name('users.delete');
            });
    }
}
