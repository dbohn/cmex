<?php

namespace Cmex\Libraries\Installer;

use Symfony\Component\Finder\Finder;

class Modules
{
    private $finder;
    private $modulebase;

    private $infos = null;

    private $adminInfos = null;

    public function __construct(Finder $finder)
    {
        $this->finder = $finder;

        $this->modulebase = __DIR__ . "/../../Modules/";
    }

    public function infos()
    {
        if (is_null($this->infos)) {
            $this->finder->files()->in($this->modulebase)->name('info.php')->depth('== 1');

            $this->infos = array();

            foreach ($this->finder as $file) {
                $this->infos[] = require $file->getPathname();
            }
        }

        return $this->infos;
    }

    public function infosForModulesWithAdmin()
    {
        if(is_null($this->adminInfos)) {
            $adminModules = \App::make('admin.modules');

            $modulebase = $this->modulebase;
            array_walk($adminModules, function(&$path) use ($modulebase) {
                $path = $modulebase . $path;
            });

            $this->finder->files()->in($adminModules)->name('info.php')->depth('== 0');

            $this->adminInfos = array();

            foreach ($this->finder as $file) {
                $moduleinfos = require $file->getPathname();
                if(!isset($moduleinfos["system"]) || $moduleinfos["system"] === false) {
                    $this->adminInfos[] = require $file->getPathname();
                }
            }
        }

        return $this->adminInfos;
    }

    public function infoForModule($module)
    {
        $module = ucfirst($module);

        if (file_exists($this->modulebase . $module . "/info.php")) {
            $info = require $this->modulebase . $module . "/info.php";

            return $info;
        }
    }
}
