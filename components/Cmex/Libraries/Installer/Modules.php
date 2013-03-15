<?php

namespace Cmex\Libraries\Installer;

use Symfony\Component\Finder\Finder;

class Modules
{
    private $finder;
    private $modulebase;

    public function __construct(Finder $finder)
    {
        $this->finder = $finder;

        $this->modulebase = __DIR__ . "/../../Modules/";
    }

    public function infos()
    {
        $this->finder->files()->in($this->modulebase)->name('info.php')->depth('== 1');

        $files = array();

        foreach ($this->finder as $file) {
            $files[] = require $file->getPathname();
        }

        return $files;
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
