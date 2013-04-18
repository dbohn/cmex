<?php

namespace Cmex\Modules\Admin\Controller;

use Cmex\Libraries\System\AdminController;
use Authentication;
use View;
use Config;

class Dashboard extends AdminController
{
    public function getIndex()
    {
        $user = Authentication::getUser();

        return View::make(
            'Admin::dashboard',
            array('user' => $user)
        );
    }
}
