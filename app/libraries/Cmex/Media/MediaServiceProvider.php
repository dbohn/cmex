<?php

namespace Cmex\Media;

use Illuminate\Support\ServiceProvider;
use Cmex\Media\MediaAccessor;

class MediaServiceProvider extends ServiceProvider {
    public function register()
    {
        $this->app['cmex.mediaaccessor'] = $this->app->share(function($app) 
        {
            $accessor = new MediaAccessor();

            // Register any configured drivers
            
            $drivers = $app['config']['mediadrivers.drivers'];

            foreach ($drivers as $driver) {
                $driverinstance = new $driver();
                $accessor->addStorage($driverinstance);
            }

            return $accessor;
        });
    }
}