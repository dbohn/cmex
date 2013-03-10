<?php

namespace Cmex\Libraries;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $modulebase = __DIR__ . '/../Modules/';
        $modulesfile = __DIR__ . '/../../../app/storage/meta/modules.json';

        // Load registered modules
        // if file does not exist, try to create it!
        if (file_exists($modulesfile)) {
            $modules = json_decode(file_get_contents($modulesfile));
        } else {
            $modrefresh = new \ModuleRefreshCommand();
            $modrefresh->fire();
            
            $modules = json_decode(file_get_contents($modulesfile));
        }

        foreach ($modules as $module) {
            $this->package('modules/'.$module, $module, $modulebase . $module);
            include $modulebase . $module . '/routes.php';
            
        }
    }

    public function register()
    {
        
    }
}
