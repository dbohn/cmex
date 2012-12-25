<?php

class LoginController extends BaseController {
    public function login() {
        //echo Input::get('name');
        return View::make('loginform');
    }

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

    public function logoff() {
        if(Auth::check()) {
            Auth::logout();
        }
        return Redirect::to('login')->with('success', 'Erfolgreich abgemeldet!');
    }
}