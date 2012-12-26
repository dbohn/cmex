<?php
namespace Cmex\Chunks;

class TextChunk extends \Chunk {
    public function config() {
        return "";
    }

    public function show($properties=array()) {
        return $this->content;
    }

    public function handleInput($data) {
        return true;
    }
}