<?php

namespace Cmex\Libraries\System;

use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{

    public function boot()
    {
        CmexLoader::register();
        $modulebase = $this->app->make('path.base') . '/components/modules/';
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

        foreach ($modules as $module) {
            CmexLoader::addNamespace('Cmex\Modules\\'.$module, $modulebase . $module . "/src");
            if (file_exists($modulebase . $module . '/src/Controller/Admin.php')) {
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
