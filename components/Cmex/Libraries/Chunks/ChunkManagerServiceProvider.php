<?php

namespace Cmex\Libraries\Chunks;

use Illuminate\Support\ServiceProvider;
use Cmex\Libraries\System\CmexLoader as Loader;

class ChunkManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        Loader::addNamespace('Cmex\Chunks', $this->app->make('path.base') . '/components/chunks');
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
