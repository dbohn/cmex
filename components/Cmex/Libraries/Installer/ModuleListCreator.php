<?php

namespace Cmex\Libraries\Installer;

use Symfony\Component\Finder\Finder;

class ModuleListCreator
{
    private $modulebase = "";

    private $storage = "";

    private $finder;

    public function __construct(Finder $finder)
    {
        $this->finder = $finder;
    }

    public function setModuleBase($newbase)
    {
        $this->modulebase = $newbase;
    }

    public function setStorage($newstorage)
    {
        $this->storage = $newstorage;
    }

    /**
     * Creates the modules.json-file which contains all modules that are loaded
     * @return boolean true on success
     */
    public function updateModuleList()
    {
        if ($this->modulebase == "") {
            throw new \InvalidArgumentException("Module base must not be empty!");
        }

        $this->finder->directories()->in($this->modulebase)->depth('== 0');
        
        $modules = array();

        foreach ($this->finder as $file) {
            if (file_exists($file->getRealpath() . "/routes.php")) {
                $modules[] = $file->getFilename();
            }
        }

        if (is_writeable(dirname($this->storage))) {
            file_put_contents(
                $this->storage,
                json_encode($modules)
            );
        }

        return true;
    }
}
