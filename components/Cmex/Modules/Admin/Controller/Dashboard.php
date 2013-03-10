<?php

namespace Cmex\Modules\Admin\Controller;

use Authentication;
use View;
use Config;

class Dashboard extends AdminController
{
    public function handle()
    {
        $user = Authentication::getUser();

        return View::make(
            'Admin::dashboard',
            array(
                'user' => $user,
                'test' => Config::get('Admin::test.testkey')
            )
        );
    }
}
