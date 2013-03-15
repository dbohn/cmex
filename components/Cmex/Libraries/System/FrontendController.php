<?php

namespace Cmex\Libraries\System;

use BaseController;
use ChunkManager;
use Config;

/**
 * Controller Base class which enables the use of chunks
 */
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

    /**
     * Override the controller callMethod to include Chunk rendering
     */
    protected function callMethod($method, $parameters)
    {
        $super = parent::callMethod($method, $parameters);

        return ChunkManager::renderChunks($super);
    }
}
