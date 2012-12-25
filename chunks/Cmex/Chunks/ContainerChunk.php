<?php

namespace Cmex\Chunks;

class ContainerChunk extends \Chunk {
    public function config() {

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
            $ret .= chunk($chunk->name, $chunk->type, $scope, array());
        }

        return $ret;
    }

    public function handleInput($data) {
        // Add chunk to container etc...
    }
}