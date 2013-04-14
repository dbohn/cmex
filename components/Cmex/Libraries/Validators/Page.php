<?php

namespace Cmex\Libraries\Validators;

class Page extends Base
{
    protected function setRules()
    {
        return array(
            'title'      => 'required',
            'identifier' => 'required',
            'template'   => 'required',
            'status'     => 'required'
        );
    }
}
