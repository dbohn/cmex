<?php

namespace Cmex\Modules\Login\Controller;

use BaseController, Authentication, View, Redirect, Input;

/**
 * This controller is responsible for doing everything related to password
 */
class Swordfish extends BaseController {
    /**
     * forgotpassword
     * Handles forgotten passwords
     * 
     * @return void
     */
    public function forgotpassword() {
        if(!Authentication::check()) {
            return View::make('Login::resetpwform');
        } else {
            return Redirect::to('');
        }
    }
    
    /**
     * forgotpassword
     * Handles forgotten passwords
     * 
     * @return void
     */
    public function newpassword($id) {
        if(!Authentication::check()) {
            return View::make('Login::newpwform', array('id' => $id, 'code' => Input::get('code', '')));
        } else {
            return Redirect::to('');
        }
    }
    
    /**
     * doReset
     * Sends resetcode
     * 
     * @return void
     */
    public function doReset() {
        try
        {
            $user = Authentication::getUserProvider()->findByLogin(Input::get('email'));
			Mail::send('emails.resetpw', $user->getResetPasswordCode(), function($m) {
				$m->to($user->email, $user->lastName . ', ' . $user->firstName)->subject('Passwort zurücksetzen...');
			});
            return Redirect::to('login')->with('success', 'Code beantragt! Eine E-Mail wurde verschickt...');
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return Redirect::to('forgotpassword')->with('error', 'Diese E-Mail ist nicht bekannt!');
        }
    }
    
    /**
     * doNewpw
     * resets password
     * 
     * @return void
     */
    public function doNewpw($id) {
        try
        {
            $user = Authentication::getUserProvider()->findById($id);
            if($user->attemptResetPassword(Input::get('code', ''), Input::get('newpassword', '')))
                return Redirect::to('login')->with('success', 'Ihr Passwort wurde zurückgesetzt!');
            else
                return Redirect::to('login')->with('error', 'Das Zurücksetzten ist fehlgeschlagen!');
        }
        catch (\Cartalyst\Sentry\Users\UserNotFoundException $e)
        {
            return Redirect::to('forgotpassword')->with('error', 'Alles falsch!');
        }
    }
}