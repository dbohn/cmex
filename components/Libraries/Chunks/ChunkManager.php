<?php

namespace Cmex\Libraries\Chunks;

use Cmex\Modules\Page\Page;

class ChunkManager
{

    private $chunks = array();

    private $chunkRepositories = array();

    private $page = null;

    private $executionStack = null;

    public function __construct()
    {
        $this->loadChunkRepositories();
        $this->initializeExecutionStack();
    }

    public function setPage(Page $p)
    {
        $this->page = $p;
    }

    public function add($name, $type, $scope=null)
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

        if (method_exists($this->chunks[$sysname], "initialize")) {
            $this->chunks[$sysname]->initialize();
        }

        // Fire event
        \Event::fire('chunk.added', array('name' => $sysname, 'type' => $type));

        if (method_exists($this->chunks[$sysname], "show")) {
            return $sysname;
        } else
        {
            return false;
        }
    }

    public function handleInput()
    {
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
            if($chunk->multichunk) {
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
     * Generates the form open tag, quite useful because it adds additional candy like chunk-field etc.
     * @param $method get|post
     * @param $formname name parameter of the form
     * @param $action Full URL where the form is handled. Let empty for current scope
     * @param $handler if you want a different chunk to handle the form, add its identifier here
     * @param $fileupload set to true if you want to upload files
     * @param $attributes further attributes for the form tag
     * @param $csrf true for automatic token addition
     */
    public function openForm($method="post", $formname="", $action="", $handler="", $fileupload=false, $attributes=array(), $csrf=true)
    {
        if (!$this->executionStack->isEmpty()) {
            $chunk = $this->executionStack->top();

            if ($action == "" || is_null($action)) {
                //$action = \URL::to($scope);
                $action = \Request::fullUrl();
            }

            if ($formname != "") {
                $formname = ' name="'.$formname.'"';
            }

            if ($fileupload) {
                $formname .= ' enctype="multipart/form-data"';
                $method = "post";
            }

            if ($handler != "") {
                $chunk = $handler;
            }

            $attstring = "";
            foreach ($attributes as $attr=>$value) {
                $attstring .= ' ' . $attr . '="'.addslashes($value).'"';
            }

            $hiddenfield = '<input type="hidden" name="chunk" value="'.$chunk.'" />';

            if ($csrf) {
                $hiddenfield .= '<input type="hidden" name="csrf_token" value="'.\Session::getToken().'" />';
            }

            return '<form action="'.$action.'" method="'.$method.'"'.$formname . $attstring .'>'.$hiddenfield;
        } else
        {
            return "Error";
        }
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
        $name = str_replace(".", "\\", $name);

        $repositories = $this->getChunkRepositories();

        if ($core) {
            $class = $repositories[0] . ucfirst($name);
            return class_exists($class) ? $class : false;
        } else {
            foreach ($repositories as $repo)
            {
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