<?php

namespace Cmex;

class AssetHandler {
    private $scripts = array();
    private $stylesheets = array();

    public function add($name, $path) {
        if(substr_compare($path, "http://", 0, 7) == 0 || substr_compare($path, "https://", 0, 8) == 0) {
            $url = $path;
        } else {
            $url = asset($path);
        }

        $args = "";
        if(func_num_args() == 3 && is_array(func_get_arg(2))) {
            foreach (func_get_arg(2) as $key => $value) {
                $args .= ' '.$key.'="'.$value.'"';
            }
        }

        // Determine type
        if(substr($path, strlen($path) - 2) == "js") {
            if(!isset($this->scripts[$name])) {
                $this->scripts[$name] = '<script src="'.$url.'"'.$args.'></script>';
            }
        } else {
            if(!isset($this->stylesheets[$name])) {
                $this->stylesheets[$name] = '<link rel="stylesheet" href="'.$url.'"'.$args.' />';
            }
        }
    }

    public function getScripts() {
        /*$ret = "";
        foreach($this->scripts as $name => $path) {
            $ret .= '<script src="'.$path.'"></script>';
        }
        return $ret;*/
        return implode("", $this->scripts);
    }

    public function getStylesheets() {
        /*$ret = "";
        foreach($this->stylesheets as $name => $path) {
            $ret .= '<link rel="stylesheet" href="'.$path.'" />';
        }
        return $ret;*/
        return implode("", $this->stylesheets);
    }

    public function get() {
        return $this->getScripts() . $this->getStylesheets();
    }
}