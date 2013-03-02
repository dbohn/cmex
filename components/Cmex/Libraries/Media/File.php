<?php

namespace Cmex\Libraries\Media;

use BadMethodCallException;

class File {
    /**
     * The internal file name
     */
    private $name;

    /**
     * This is the URL to the associated file under which it can be 
     * included into the page
     */
    private $externPath;

    /**
     * The path in the virtual file tree
     */
    private $internalPath;

    /**
     * true if the file is stored on the local system,
     * false otherwise
     */
    private $local;

    private $mimetype;

    private $freeze = false;

    public function setName($name) 
    {
        if (!$this->freeze) {
            $this->name = $name;
        } else {
            throw new BadMethodCallException("The object is frozen, you cannot call this method anymore!");
        }
    }

    public function setExternPath($path) 
    {
        if (!$this->freeze) {
            $this->externPath = $path;
        } else {
            throw new BadMethodCallException("The object is frozen, you cannot call this method anymore!");
        }
    }

    public function setInternalPath($path) 
    {
        if (!$this->freeze) {
            $this->internalPath = $path;
        } else {
            throw new BadMethodCallException("The object is frozen, you cannot call this method anymore!");
        }
    }

    public function setLocal($local) 
    {
        if (!$this->freeze) {
            $this->local = $local;
        } else {
            throw new BadMethodCallException("The object is frozen, you cannot call this method anymore!");
        }
    }

    public function setMimeType($mime) 
    {
        if (!$this->freeze) {
            $this->mimetype = $mime;    
        } else {
            throw new BadMethodCallException("The object is frozen, you cannot call this method anymore!");
        }
    }

    /**
     * If this method was called, the object cannot be changed anymore!
     * So any call to a set-Method will fail!
     */
    public function freezeObject() 
    {
        $this->freeze = true;
    }

    public function isFrozen()
    {
        return $this->freeze;
    }

    public function isLocal() 
    {
        return $local;
    }

    public function getInternalPath() 
    {
        return $this->internalPath;
    }

    public function getExternPath() 
    {
        return $this->externPath;
    }

    public function getMimeType()
    {
        return $this->mimetype;
    }
}