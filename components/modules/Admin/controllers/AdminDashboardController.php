<?php

namespace Cmex\Modules\Admin;

use Authentication, View, Config;

class AdminDashboardController extends AdminController
{
    public function handle()
    {
        $user = Authentication::getUser();

        return View::make('Admin::dashboard', array('user' => $user, 'test' => Config::get('Admin::test.testkey')));
    }
}