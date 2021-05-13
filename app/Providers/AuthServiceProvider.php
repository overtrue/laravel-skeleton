<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot()
    {
        $this->registerPolicies();

        Sanctum::ignoreMigrations();

        Gate::guessPolicyNamesUsing(function ($modelClass) {
            return \sprintf('App\Policies\%sPolicy', \class_basename($modelClass));
        });
    }
}
