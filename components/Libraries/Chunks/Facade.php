<?php

namespace Cmex\Libraries\Chunks;

use Illuminate\Support\Facades\Facade as IlluFacade;

class Facade extends IlluFacade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "cmex.chunkmanager";
    }
}