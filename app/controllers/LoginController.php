<?php

class LoginController extends BaseController {
    /**
     * login 
     * shows Loginform
     *
     * @access public
     * @return void
     */
    public function login() {
        if(!Auth::check()) {
		return View::make('loginform');
	} else {
		return Redirect::to('');
	}
    }

    /**
     * auth
     * Handles authentication 
     * 
     * @access public
     * @return void
     */
    public function auth() {
        if(Input::has('name') && Input::has('password')) {
            $credentials = array('name' => Input::get('name'), 
                'password' => Input::get('password'));
    
            if(Auth::attempt($credentials)) {
                return Redirect::to('admin/overview');
            } else {
                return Redirect::to('login')->with('error', 'Falsche Logindaten!');
            }
        } else {
            return Redirect::to('login')->with('error', 'Direktaufruf der Authentifizierung nicht möglich!');
        }
    }

    /**
     * logoff 
     * Handles logout
     *
     * @access public
     * @return void
     */
    public function logoff() {
        if(Auth::check()) {
            Auth::logout();
        }
        return Redirect::to('login')->with('success', 'Erfolgreich abgemeldet!');
    }
}
