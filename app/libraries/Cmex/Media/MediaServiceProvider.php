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
                $classname = class_basename($driver);
                $driverinstance = new $driver(\Config::get('mediadrivers.'.strtolower($classname)));
                $accessor->addStorage($driverinstance);
            }

            return $accessor;
        });
    }
}