<?php

namespace Chunks\Cmex\Search;

class SmallSearchForm extends \Chunk {

    public function show($properties = array()) {
        $cobj = json_decode($this->content);
        return \View::make('Cmex.Search.views.smallSearchView', array(
            'viewPage' => \path($cobj->page),
            'responsibleChunk' => $cobj->page . "_" . $cobj->chunk
        ));
    }

    public function handleInput($data) {
        
    }

    public function annotate() 
    {
        return array();
    }
}