<?php

namespace Cmex\Libraries\Meta;

use Illuminate\Support\Facades\Facade;

class AssetFacade extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return "cmex.asset";
    }
}