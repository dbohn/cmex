<?php

namespace Cmex\Media;

use \Cmex\Media\File;
use \Cmex\Media\DriverInterface;
use InvalidArgumentException;

class MediaAccessor {
    private $storages = array();

    public function addStorage(DriverInterface $driver) {
        $key = $driver->respondsToKey();
        $this->storages[$key] = $driver;
    }

    public function lookupFile($path) {
        // Extract driver
        $pathcomponents = explode("/", $path);

        $key = $pathcomponents[0];

        unset($pathcomponents[0]);

        $driverpath = '/'.implode("/", $pathcomponents);

        if(isset($this->storages[$key]))
        {
            return $this->storages[$key]->getFileForPath($driverpath);
        } else
        {
            throw new InvalidArgumentException("Driver " . $key . " was not found!");
        }
    }

    public function test() {
        return $this->storages['local']->respondsToKey();
    }
}