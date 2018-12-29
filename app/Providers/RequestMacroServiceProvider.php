<?php

namespace App\Providers;

use App\Company;
use App\Traits\Commentable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;

class RequestMacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $this->registerModelRelationIncludes();
    }

    /**
     * 请求加载的模型关系
     */
    protected function registerModelRelationIncludes()
    {
        Request::macro('includes', function () {
            $request = request();

            if ($request->has('include')) {
                return array_filter(\array_map('trim', \explode(',', $request->get('include'))));
            }

            return [];
        });
    }
}
