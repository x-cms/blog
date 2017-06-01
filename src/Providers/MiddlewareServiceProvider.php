<?php

namespace Xcms\Blog\Providers;

use Illuminate\Support\ServiceProvider;
use Xcms\Blog\Http\Middleware\NavMiddleware;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', NavMiddleware::class);
    }
}
