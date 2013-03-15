<?php

namespace Cmex\Modules\Admin\Controller;

use Controller;
use View;
use App;

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
            $modules = App::make('Cmex\Libraries\Installer\Modules');
            $data = $modules->infos();
            View::share('cmexmodules', $data);
            $this->layout = View::make($this->layout);
        }
    }
}
