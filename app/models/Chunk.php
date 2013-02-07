<?php

use Cmex\ChunkManager\ChunkNotFoundException;

abstract class Chunk {
    protected $properties = array();
    protected $name = "";
    protected $scope = "";
    protected $type = "";
    private $chunkstorage = null;

    public function __construct() {
        // Determine chunk type
        // PHP 5.3 goodness :D
        $type = get_called_class();
        $type = explode("\\", $type);
        $this->type = end($type);
        
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
    protected function openForm($method="post", $formname="", $action="", $handler="", $fileupload=false, $attributes=array(), $csrf=true) {
        $chunk = $this->scope . "_" . $this->name;

        if($action == "" || is_null($action)) {
            //$action = \URL::to($scope);
            $action = \Request::fullUrl();
        }

        if($formname != "") {
            $formname = ' name="'.$formname.'"';
        }

        if($fileupload) {
            $formname .= ' enctype="multipart/form-data"';
            $method = "post";
        }

        if($handler != "") {
            $chunk = $handler;
        }

        $attstring = "";
        foreach($attributes as $attr=>$value) {
            $attstring .= ' ' . $attr . '="'.$value.'"';
        }

        $hiddenfield = '<input type="hidden" name="chunk" value="'.$chunk.'" />';
        if($csrf) {
            $hiddenfield .= '<input type="hidden" name="csrf_token" value="'.Session::getToken().'" />';
        }

        return '<form action="'.$action.'" method="'.$method.'"'.$formname . $attstring .'>'.$hiddenfield;
    }

    public function handleConfig() {
        // Show edit button etc. pp.
        $return = "";
        //$return = '<div class="configbutton" title="Edit chunk of type: '.$this->type.'" rel="'.$this->scope.'_'.$this->name.'">&#x2699;</div>';
        // Finally handle chunk config-code:
        return $return . $this->config();
    }

    public function setProperty($property, $value) {
        $this->properties[$property] = $value;
    }

    public function setProperties(array $properties) {
        $this->properties = array_merge($this->properties, $properties);
    }

    public function setChunkName($scope, $name) {
        $this->scope = $scope;
        $this->name = $name;
    }

    public function __get($key) {
        if($key == 'content') {
            if($this->chunkstorage === null) {
                $chunkdb = DB::table('chunks')->where('name', $this->scope . "_" . $this->name)->first();
                if($chunkdb === null) {
                    throw new ChunkNotFoundException('Chunk was not found!');
                }
                $this->chunkstorage = array('content' => $chunkdb->content);
            }
            return $this->chunkstorage['content'];
        } else if($key == 'identifier') {
            return $this->scope . '_' . $this->name;
        }

        throw new IllegalArgumentException('Unknown property!');
    }

    /**
     * In this method you can define your configuration
     * You're free to use any way of config, you want.
     * a text widget could e.g. load a wysiwyg editor,
     * a contact widget could instead just show a form to set recipient
     */
    public abstract function config();

    public abstract function handleInput($data);
}