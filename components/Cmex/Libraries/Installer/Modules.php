<?php

namespace Cmex\Libraries\Installer;

use Symfony\Component\Finder\Finder;

class Modules
{
    private $finder;
    private $modulebase;

    private $infos = null;

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

            return $this->infos;
        }

        return $this->infos;
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
