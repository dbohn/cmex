<?php

namespace Chunks\Cmex\Search;

class SearchResults extends \Chunk {
	private $searchquery = false;

    public function show() {
        if(!$this->searchquery) {
        	return "Es wurde keine Suchanfrage ausgeführt!";
        }
        return $this->searchquery;
    }

    public function handleInput($data) {
        $this->searchquery = $data['searchquery'];
        return true;
    }

    public function annotate()
    {
        return array();
    }
}