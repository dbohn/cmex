<?php

namespace Cmex\Libraries\Media;

use Illuminate\Support\Facades\Facade as IlluFacade;

class Facade extends IlluFacade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "cmex.mediaaccessor";
    }
}