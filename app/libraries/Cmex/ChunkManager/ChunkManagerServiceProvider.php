<?php

namespace Cmex\ChunkManager;

use Illuminate\Support\ServiceProvider;

class ChunkManagerServiceProvider extends ServiceProvider {
    public function register()
    {
        $this->app['cmex.chunkmanager'] = $this->app->share(function($app)
        {
            return new ChunkManager();
        });
    }
}