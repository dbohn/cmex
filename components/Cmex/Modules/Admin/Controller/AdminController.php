<?php

namespace Cmex\Modules\Admin\Controller;

use Controller;
use View;
use App;

class AdminController extends Controller
{
    protected $layout = null;

    public function __construct()
    {
        $this->beforeFilter('auth');

        $modules = App::make('Cmex\Libraries\Installer\Modules');
        
        $data = $modules->infosForModulesWithAdmin();
        View::share('cmexmodules', $data);
    }
}
