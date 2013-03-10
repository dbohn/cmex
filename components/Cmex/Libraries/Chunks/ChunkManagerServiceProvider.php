<?php

namespace Cmex\Libraries\Chunks;

use Illuminate\Support\ServiceProvider;

class ChunkManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app['cmex.chunkmanager'] = $this->app->share(
            function ($app) {
                return new ChunkManager();
            }
        );
    }

    public function provides()
    {
        return array('cmex.chunkmanager');
    }
}
