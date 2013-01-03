<?php
namespace Chunks\Cmex;
use Chunks\Cmex\Search\SearchableInterface;

class Text extends \Chunk implements SearchableInterface {
    public function config() {
        return "";
    }

    public function getIndex() {
        return $this->content;
    }

    public function show($properties=array()) {
        return $this->content;
    }

    public function handleInput($data) {
        return true;
    }
}