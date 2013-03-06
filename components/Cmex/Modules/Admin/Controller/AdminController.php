<?php

namespace Cmex\Modules\Admin\Controller;

use BaseController;

class AdminController extends BaseController
{
    protected $layout = "Admin::layout";

    public function __construct()
    {
        $this->beforeFilter('auth');
    }
}