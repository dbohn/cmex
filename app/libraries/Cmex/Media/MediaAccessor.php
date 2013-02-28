<?php

namespace Cmex\Media;

use \Cmex\Media\File;
use \Cmex\Media\DriverInterface;
use InvalidArgumentException;

class MediaAccessor {
    private $storages = array();

    public function addStorage(DriverInterface $driver) 
    {
        $key = $driver->respondsToKey();
        $this->storages[$key] = $driver;
    }

    public function lookupFile($path) 
    {
        $path = $this->cleanFilePath($path);
        // Extract driver
        $pathcomponents = explode("/", $path);

        $key = $pathcomponents[0];

        unset($pathcomponents[0]);

        $driverpath = '/'.implode("/", $pathcomponents);

        if (isset($this->storages[$key])) {
            return $this->storages[$key]->getFileForPath($driverpath);
        } else {
            throw new InvalidArgumentException("Driver " . $key . " was not found!");
        }
    }

    public function cleanFilePath($dirtyPath) 
    {
        // Check for driver
        if($dirtyPath[0] == "/") {
            $dirtyPath = substr($dirtyPath, 1);
        }

        $pathcomponents = explode("/", $dirtyPath);
        $driver = $pathcomponents[0];

        if (isset($this->storages[$driver])) {
            // Drop any malicious characters
            $path = strip_tags($dirtyPath);

            // Removes non-ASCII-chars
            $path = preg_replace('/[^(\x20-\x7F)]*/','', $path);

            // Reomve 0-byte and ../
            $path = str_replace("\0", '', $path);
            $path = str_replace("../", '', $path);

            return $path;
        } else {
            throw new InvalidArgumentException("Driver " . $driver . " was not found!");
        }

    }
}