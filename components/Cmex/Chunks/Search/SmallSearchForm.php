<?php

namespace Cmex\Chunks\Search;

use Cmex\Libraries\Chunks\Chunk;
use URL;

class SmallSearchForm extends Chunk
{
    public function show()
    {
        $cobj = json_decode($this->content);
        return \View::make(
            'Search.views.smallSearchView',
            array(
                'viewPage' => URL::to($cobj->page),
                'responsibleChunk' => $cobj->page . "_" . $cobj->chunk
            )
        );
    }

    public function handleInput($data)
    {
        
    }

    public function annotate()
    {
        return array();
    }
}
