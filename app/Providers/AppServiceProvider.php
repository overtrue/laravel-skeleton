<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerRequestRelationMarco();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    public function registerRequestRelationMarco()
    {
        Request::macro('relations', function (array $allows = []) {
            $request = \request();

            if ($request->has('with')) {
                $relations = \array_filter(\array_map('trim', \explode(';', $request->get('with'))));

                if (!empty($allows)) {
                    return \array_intersect($allows, $relations);
                }

                return $relations;
            }

            return [];
        });
    }
}
