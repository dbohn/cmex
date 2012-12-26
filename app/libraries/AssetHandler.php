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

        // Determine type
        if(substr($path, strlen($path) - 2) == "js") {
            if(!isset($this->scripts[$name])) {
                $this->scripts[$name] = $url;
            }
        } else {
            if(!isset($this->stylesheets[$name])) {
                $this->stylesheets[$name] = $url;
            }
        }
    }

    public function getScripts() {
        $ret = "";
        foreach($this->scripts as $name => $path) {
            $ret .= '<script src="'.$path.'"></script>';
        }
        return $ret;
    }

    public function getStylesheets() {
        $ret = "";
        foreach($this->stylesheets as $name => $path) {
            $ret .= '<link rel="stylesheet" href="'.$path.'" />';
        }
        return $ret;
    }

    public function get() {
        return $this->getScripts() . $this->getStylesheets();
    }
}