<?php

namespace Cmex\Asset;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider {
    public function register()
    {
        $this->app['cmex.asset'] = $this->app->share(function($app)
        {
            return new Asset();
        });
    }
}