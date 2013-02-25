<?php

namespace Cmex\Media\Driver;

use Cmex\Media\DriverInterface;
use Cmex\Media\File;
use Cmex\Media\FileNotFoundException;

class FileSystem implements DriverInterface {

    private $baseUrl;
    private $basePath;

    public function __construct($config)
    {
        // Read config values
        $this->baseUrl = $config['baseUrl'];
        $this->basePath = $config['basePath'];
    }

    public function addFile($path, $file)
    {

    }

    public function removeFile($path)
    {

    }

    public function createDirectory($path)
    {

    }

    public function removeDirectory($path, $withContents)
    {

    }

    public function isEmptyDirectory($path)
    {

    }

    public function fileExists($path)
    {
        return file_exists($this->buildRealPath($path, $this->basePath));
    }

    public function getFileForPath($path)
    {
        if($this->fileExists($path)) {
            $url = $this->buildRealPath($path, $this->baseUrl);

            $file = new File();
            $file->setExternPath($url);
            $file->setInternalPath($this->respondsToKey() . $path);
            $file->setLocal(true);
            $file->setMimeType($this->detectMime($path));
            $file->setName($this->getFileName($path));
            $file->freezeObject();
            return $file;
        } else {
            throw new FileNotFoundException("File " . $path . " was not found!");
        }
        return $this->baseUrl[0];
    }

    public function getDirectoryTree($root)
    {
        
    }

    public function respondsToKey()
    {
        return "local";
    }

    private function buildRealPath($path, $base)
    {
        if($path[0] == "/")
        {
            $path = substr($path, 1);
        }

        return $base . $path;
    }

    private function getFileName($path)
    {
        $pathcomponents = explode("/", $path);

        return end($pathcomponents);
    }

    private function detectMime($path)
    {
        $syspath = $this->buildRealPath($path, $this->basePath);

        $finfo = finfo_open(FILEINFO_MIME_TYPE);

        $mime = finfo_file($finfo, $syspath);

        finfo_close($finfo);

        return $mime;
    }
}