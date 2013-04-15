<?php

namespace Cmex\Libraries\Chunks;

use Illuminate\Support\Contracts\RenderableInterface as Renderable;

class ChunkManager
{

    private $chunks = array();

    private $chunkRepositories = array();

    private $pageIdentifier = "";

    private $executionStack = null;

    private $inputHandled = false;

    private $componentPath = "";

    public function __construct()
    {
        $this->loadChunkRepositories();
        $this->initializeExecutionStack();

        $this->componentPath = app_path() . '/../components/';
    }

    public function add($name, $type, $scope = null)
    {
        if (is_null($scope)) {
            $scope = $this->getPageIdentifier();
        }

        $sysname = $this->createSystemName($name, $scope);

        if (isset($this->chunks[$sysname])) {
            throw new ChunkAlreadyExistsException("There's already a chunk with the exact same name loaded!");
        }

        if (($class = $this->chunkExists($type, true)) === false) {
            throw new InvalidChunkTypeException("Chunk of type " . $type . " does not exist!");
        }

        $this->chunks[$sysname] = new $class();
        $this->chunks[$sysname]->setChunkName($scope, $name);

        // Add chunk collection as a View-namespace, allows for easy view name syntax (like for modules)
        $path = '../components/'. dirname(str_replace('\\', '/', $class));

        $collection = basename($path);

        \View::addNamespace("Chunks/".$collection, $path . '/views');
        

        if (method_exists($this->chunks[$sysname], "initialize")) {
            $this->chunks[$sysname]->initialize();
        }

        // Fire event
        \Event::fire('chunk.added', array('name' => $sysname, 'type' => $type));

        if (method_exists($this->chunks[$sysname], "show")) {
            return $sysname;
        } else {
            return false;
        }
    }

    public function handleInput()
    {
        $this->inputHandled = true;
        if (\Input::has("chunk")) {
            $chunk = \Input::get("chunk");
            if (isset($this->chunks[$chunk]) && method_exists($this->chunks[$chunk], "handleInput")) {
                $this->chunks[$chunk]->handleInput(\Input::get());
            }
        }
    }

    public function showForKey($key)
    {
        $chunk = $this->getChunkForKey($key);

        // Put the chunk on the execution stack
        $this->executionStack[] = $key;

        $attributes = "";

        if (\Authentication::check()) {
            // Annotate the elements block for the admin panel
            $type = strtolower($chunk->type);
            $multichunk = "";
            if ($chunk->multichunk) {
                $multichunk = ' rel="dcterms:hasPart"';
            }

            $attributes .= $multichunk . ' typeof="' . $type . '" about="chunks/' . $key . '"';

        }

        $chunkContent = '' . $chunk->show();

        // Remove chunk from execution stack

        $this->executionStack->pop();

        return '<div id="' . $key . '" ' . $attributes . '>' . $chunkContent . '</div>';
    }

    /**
     * Executes the render loop for all registered chunks and 
     * injects the result into the given view
     * @param $view string|\Illuminate\View\View
     * @return string rendered view
     */
    public function renderChunks($view)
    {
        if ($view instanceof Renderable) {
            $view = $view->render();
        } else {
            return $view;
        }

        if (!$this->inputHandled) {
            $this->handleInput();
        }

        foreach ($this->getLoadedChunks() as $chunk) {
            $view = str_replace('__'.$chunk.'__', $this->showForKey($chunk), $view);
        }

        return $view;
    }

    public function getChunkForKey($key)
    {
        if (isset($this->chunks[$key])) {
            return $this->chunks[$key];
        } else {
            throw new ChunkNotFoundException();
        }
    }

    public function getPageIdentifier()
    {
        return $this->pageIdentifier;
    }

    public function setPageIdentifier($pi)
    {
        $this->pageIdentifier = $pi;
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
        $name = str_replace(".", "\\", $name);

        $repositories = $this->getChunkRepositories();

        if ($core) {
            $class = $repositories[0] . ucfirst($name);
            return class_exists($class) ? $class : false;
        } else {
            foreach ($repositories as $repo) {
                $class = $repo . ucfirst($name);

                if (class_exists($class)) {
                    return $class;
                }
            }

            return false;
        }

        return false;
    }

    public function getChunkRepositories()
    {
        return $this->chunkRepositories;
    }

    private function loadChunkRepositories()
    {
        return ($this->chunkRepositories = array("Cmex\\Chunks\\"));
    }

    private function initializeExecutionStack()
    {
        $this->executionStack = new \SplStack();
    }
}
