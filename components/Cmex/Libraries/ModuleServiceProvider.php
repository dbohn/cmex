<?php

namespace Cmex\Libraries;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $modulebase = __DIR__ . '/../Modules/';
        $modulesfile = storage_path() . '/meta/modules.json';

        // Load registered modules
        // if file does not exist, try to create it!
        if (file_exists($modulesfile)) {
            $modules = json_decode(file_get_contents($modulesfile));
        } else {
            $modrefresh = $this->app->make('Cmex\Libraries\Installer\ModuleListCreator');
            $modrefresh->setModuleBase($modulebase);
            $modrefresh->setStorage($modulesfile);
            $modrefresh->updateModuleList();
            
            $modules = json_decode(file_get_contents($modulesfile));
        }

        $adminmodules = array();

        // TODO: Could be stored in modules.json...
        foreach($modules as $module) {
            if(file_exists($modulebase . $module . '/Controller/Admin.php')) {
                $adminmodules[] = $module;
            }
        }

        $this->app['admin.modules'] = $adminmodules;

        foreach ($modules as $module) {
            $this->package('modules/'.$module, $module, $modulebase . $module);

            include $modulebase . $module . '/routes.php';
        }
    }

    public function register()
    {
        
    }
}
