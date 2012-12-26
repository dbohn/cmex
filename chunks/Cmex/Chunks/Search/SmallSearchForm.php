<?php

namespace Cmex\Chunks\Search;

class SmallSearchForm extends \Chunk {
    public function config() {
        return "";
    }

    public function show($properties = array()) {
        return '<div class="input-append">
  <input class="span2" id="appendedInputButton" placeholder="Suche..." type="text">
  <button class="btn" type="button">Go!</button>
</div>';
    }

    public function handleInput($data) {
        // Add chunk to container etc...
    }
}