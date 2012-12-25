<?php

abstract class Chunk {
    protected $properties = array();
    protected $name = "";
    protected $content = "";
    protected $page = "";

    /**
     * In this method you can define your configuration
     * You're free to use any way of config, you want.
     * a text widget could e.g. load a wysiwyg editor,
     * a contact widget could instead just show a form to set recipient
     */
    public abstract function config();

    public abstract function show($properties);

    public function setProperty($property, $value) {
        $this->properties[$property] = $value;
    }

    public function setProperties(array $properties) {
        $this->properties = array_merge($this->properties, $properties);
    }

    /**
     * This method fetches the chunk information by the name
     * of the chunk, see it as an init-Method
     */
    public function fetchByChunkName($name) {
        $pagename = explode("_", $name);
        $this->page = $pagename[0];
        $chunkdb = DB::table('chunks')->where('name', $name)->first();
        if(!is_null($chunkdb))
        {
            $this->name = $name;
            $this->content = $chunkdb->content;
            return $this;
        } else {
            return null;
        }

        //return $chunkdb->type;
    }

    public abstract function handleInput($data);
}