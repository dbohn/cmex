<?php

class AdminDashboardController extends AdminController
{
    public function handle()
    {
        $user = Authentication::getUser();

        return View::make('admin.dashboard', array('user' => $user));
        /*if ($user->isSuperUser())
        {
            return "Super-Administration - Sie sind eingeloggt als: ". $user->first_name . " " . $user->last_name . "<a href='".URL::to('/')."'>Startseite</a>";
        } else
        {
            return 
        }*/
    }
}