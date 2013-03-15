<?php

namespace Cmex\Libraries\System;

use BaseController;
use ChunkManager;
use Config;

class FrontendController extends BaseController
{
    protected $identifier = "";
    protected $template = "default";

    public function __construct()
    {
        $this->template = Config::get('cmex.template');

        ChunkManager::setPageIdentifier($this->identifier);
    }

    public function setPageIdentifier($pi)
    {
        $this->identifier = $pi;

        ChunkManager::setPageIdentifier($pi);
    }
}
