<?php

class AdminMediaController extends AdminController {
    public function handle()
    {
        $user = Authentication::getUser();

        return View::make('admin.mediamanager', array('user' => $user));
    }
}