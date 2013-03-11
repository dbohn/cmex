<?php

namespace Cmex\Modules\Admin\Controller;

use Controller;
use View;

class AdminController extends Controller
{
    protected $layout = "Admin::layout";

    public function __construct()
    {
        $this->beforeFilter('auth');
    }

    protected function setupLayout()
    {
        if (!is_null($this->layout)) {
            $this->layout = View::make($this->layout);
        }
    }
}
