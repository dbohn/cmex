<?php

namespace Cmex\Libraries;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider {
    public function register()
    {
        $modulebase = __DIR__ . '/../modules/';
        // Load config for the modules
        $modules = scandir($modulebase);

        // TODO: Querying the modules directory should not be done on every
        // request as especially the is_dir() call is quite resource intense.
        // There should be somehow a registry. But for the purpose of having
        // modules during development, this should be good (for now)
        foreach($modules as $module) {
            if(is_dir($modulebase . $module) && $module[0] != ".") {
                // Add configuration if there is some
                /*$this->app['config']->package('modules/'.$module, $modulebase . $module . '/config');

                // Add view folder for the modules
                $this->app['view']->addNamespace($module, $modulebase . $module . '/views');*/

                $this->package('modules/'.$module, $module, $modulebase . $module);

                // Load routes - yak, another filesystem call - slow!
                if(file_exists($modulebase . $module . '/routes.php')) {
                    include $modulebase . $module . '/routes.php';
                }
            }
            
        }
    }
}