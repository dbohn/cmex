<?php

namespace Cmex\ChunkManager;

class ChunkManager
{

    private $chunks = array();

    private $chunkRepositories = array();

    private $page = null;

    public function __construct()
    {
        $this->loadChunkRepositories();
    }

    public function setPage(\Page $p)
    {
        $this->page = $p;
    }

    public function add($name, $type, $scope=null)
    {
        if (is_null($scope))
        {
            $scope = $this->getPageIdentifier();
        }

        $sysname = $this->createSystemName($name, $scope);

        if (isset($this->chunks[$sysname]))
        {
            throw new ChunkAlreadyExistsException("There's already a chunk with the exact same name loaded!");
        }

        if (($class = $this->chunkExists($type, true)) === false) 
        {
            throw new InvalidChunkTypeException("Chunk of type " . $type . " does not exist!");
        }

        $this->chunks[$sysname] = new $class();
        $this->chunks[$sysname]->setChunkName($scope, $name);

        if (method_exists($this->chunks[$sysname], "initialize"))
        {
            $this->chunks[$sysname]->initialize();
        }

        // Fire event
        \Event::fire('chunk.added', array('name' => $sysname, 'type' => $type));

        if (method_exists($this->chunks[$sysname], "show"))
        {
            return $sysname;
        } else
        {
            return false;
        }
    }

    public function handleInput()
    {
        if (\Input::has("chunk"))
        {
            $chunk = \Input::get("chunk");
            if (isset($this->chunks[$chunk]) && method_exists($this->chunks[$chunk], "handleInput"))
            {
                $this->chunks[$chunk]->handleInput(\Input::get());
            }
        }
    }

    public function showForKey($key)
    {
        $chunk = $this->getChunkForKey($key);

        if (\Authentication::check())
        {
            $type = strtolower($chunk->type);
            $multichunk = "";
            if($chunk->multichunk)
            {
                $multichunk = ' rel="dcterms:hasPart"';
            }
            return '<div id="' . $key . '"'.$multichunk.' about="chunks/' . $type . '">'. $chunk->handleConfig() . $chunk->show() . '</div>';
        }
        return '<div id="' . $key . '">' . $chunk->show() . '</div>';
    }

    public function getChunkForKey($key)
    {
        if (isset($this->chunks[$key]))
        {
            return $this->chunks[$key];
        } else
        {
            throw new ChunkNotFoundException();
        }
    }

    public function getPageIdentifier()
    {
        return $this->page->identifier;
    }

    public function getLoadedChunks()
    {
        return array_keys($this->chunks);
    }

    public function createSystemName($name, $scope)
    {
        return $scope . "_" . $name;
    }

    public function chunkExists($name, $core = true)
    {
        $name = str_replace("_", "\\", $name);

        $repositories = $this->getChunkRepositories();

        if ($core) 
        {
            $class = $repositories[0] . ucfirst($name);
            return class_exists($class) ? $class : false;
        } else
        {
            foreach($repositories as $repo)
            {
                $class = $repo . ucfirst($name);

                if(class_exists($class))
                {
                    return $class;
                }
            }

            return false;
        }

        return false;
    }

    public function loadChunkRepositories()
    {
        return ($this->chunkRepositories = array("Chunks\\Cmex\\"));
    }

    public function getChunkRepositories()
    {
        return $this->chunkRepositories;
    }
}