<?php

abstract class Chunk {
    protected $properties = array();
    protected $name = "";
    protected $content = "";
    protected $page = "";
    protected $type = "";
    protected $form = null;
    private $tagdecorator = null;

    public function __construct() {
        // Determine chunk type
        // PHP 5.3 goodness :D
        $type = get_called_class();
        $type = explode("\\", $type);
        $this->type = end($type);
        
    }

    /**
     * Returns a prepared form instance.
     * It automatically prepends the chunk name to fields
     * We don't want to use the Singleton-like Laravel Interface,
     * because we have to prepend different things for every chunk
     * that way we don't have to care about how to remove the previous
     * settings in the class
     **/
    protected function getForm() {
        if(is_null($this->form)) {
            $this->tagdecorator = new \Html\TagDecorator();
            $form = new \Form\FormHandler($this->tagdecorator);
            $page = $this->page;
            $name = $this->name;

            // Add hidden field with chunk name
            $form->include_all(function() use ($form, $page, $name) {
                return $form->template('div', function($f) use ($page, $name) {
                    $f->hidden('chunk')->value($page . "_" . $name);

                    $f->hidden('csrf_token')->value(Session::getToken());
                    $f->setClass('sys');
                });
            });

            $this->form = $form;
            return $this->form;
        } else {
            return $this->form;
        }
    }

    public function handleConfig() {
        // Show edit button etc. pp.
        $return = '<div class="configbutton" title="Edit chunk of type: '.$this->type.'" rel="'.$this->page.'_'.$this->name.'">&#x2699;</div>';
        // Finally handle chunk config-code:
        return $return . $this->config();
    }

    /**
     * In this method you can define your configuration
     * You're free to use any way of config, you want.
     * a text widget could e.g. load a wysiwyg editor,
     * a contact widget could instead just show a form to set recipient
     */
    public abstract function config();

    /**
     * Creates the basic view
     * @return HTML code
     */
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
    public function fetchByChunkName($scope, $name) {
        //$pagename = explode("_", $name);
        $this->page = $scope;
        $chunkdb = DB::table('chunks')->where('name', $scope . "_" . $name)->first();
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