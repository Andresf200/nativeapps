<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\JsonApi\Mixins\JsonApiQueryBuilder;
use Illuminate\Database\Eloquent\Builder;


class JsonApiServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            \App\Exceptions\Handler::class,
            //\App\JsonApi\Exceptions\Handler::class
        );
    }

    public function boot()
    {
        Builder::mixin(new JsonApiQueryBuilder());
    }
}
