<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Bridge\PersonalAccessGrant;
use League\OAuth2\Server\AuthorizationServer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     * @throws \Exception
     */
    public function boot()
    {
        Resource::withoutWrapping();
        //$this->setPersonalAccessTokenExpiresIn();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * @throws \Exception
     */
    protected function setPersonalAccessTokenExpiresIn(): void
    {
        if ($this->app->has(AuthorizationServer::class)) {
            $this->app->get(AuthorizationServer::class)
                ->enableGrantType(new PersonalAccessGrant(), new \DateInterval('P1W'));
        }
    }
}
