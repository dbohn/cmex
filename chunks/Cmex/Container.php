<?php

namespace Chunks\Cmex;
use \Chunks\Cmex\Search\SearchableInterface;

class Container extends \Chunk implements SearchableInterface {
    public function config() {
        return "";
    }

    public function getIndex() {
        $ret = array();
        $chunks = json_decode($this->content);

        foreach($chunks as $chunk) {
            if($inst = rawChunk($chunk->name, $chunk->type, $scope)) {
                if($inst instanceof SearchableInterface) {
                    $ret[] = array('name' => $chunk->name, 'index' => $inst->getIndex());
                }
            }
        }
        return $ret;
    }

    public function show($properties = array()) {
        $chunks = json_decode($this->content);
        
        $ret = "";
        foreach($chunks as $chunk) {
            // Wenn ein Scope angegeben wurde, wähle diesen,
            // ansonsten lokaler Scope
            if(property_exists($chunk, 'scope')) {
                $scope = $chunk->scope;
            } else {
                $scope = $this->page;
            }
            if(property_exists($chunk, 'properties')) {
                $ret .= call_user_func_array('chunk', array_merge(array($chunk->name, $chunk->type, $scope), $chunk->properties));
            } else
            {
                $ret .= chunk($chunk->name, $chunk->type, $scope);
            }
        }

        return $ret;
    }

    public function handleInput($data) {
        // Add chunk to container etc...
    }
}