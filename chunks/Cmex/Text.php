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
        $_ = $this;
        $value = \Cache::remember($this->identifier, 10, function() use($_) {
            return $_->content;
        });
        //return $this->content;
        return $value;
    }

    public function handleInput($data) {
        return true;
    }
}