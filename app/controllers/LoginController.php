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
        if(!Authentication::check()) {
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
            try {
                $credentials = array(
                    'email' => Input::get('name'), 
                    'password' => Input::get('password')
                );

                $rememberMe = (Input::has("remember-me") && Input::get("remember-me") == "remember-me") ? true : false;
        
                if($user = Authentication::authenticate($credentials, $rememberMe)) {
                    // FIX THAT SECURITY ISSUE! :D
                    if(Input::has('chunk'))
                    {
                        return Redirect::to(Input::get('chunk'));
                    }
                    return Redirect::to('admin');
                } else {
                    return Redirect::to('login')->with('error', 'Falsche Logindaten!');
                }
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                Log::info($e->getMessage());
                return Redirect::to('login')->with('error', 'Der Benutzer wurde nicht gefunden!');
            } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
                Log::info($e->getMessage());
                return Redirect::to('login')->with('error', 'Es muss ein Login-Feld angegeben werden!' . $e->getMessage());
            } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                Log::info($e->getMessage());
                return Redirect::to('login')->with('error', 'Der Nutzer ist nicht aktiviert!');
            } catch (Exception $e) {
                Log::error($e->getMessage());
                return Redirect::to('login')->with('error', $e->getMessage());
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
        if(Authentication::check()) {
            Authentication::logout();
        }

        return Redirect::to('login')->with('success', 'Erfolgreich abgemeldet!');
    }
	
	/**
	 * forgotpassword
	 * Handles forgotten passwords
	 * 
	 * @return void
	 */
	public function forgotpassword() {
		if(!Authentication::check()) {
            return View::make('resetpwform');
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
            return View::make('newpwform', array('id' => $id));
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
			return Redirect::to('newpassword/' . $user->id)->with('success', 'Ihr Rücksetztcode lautet: ' . $user->getResetPasswordCode());
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
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
			if($user->attemptResetPassword(Input::get('resetcode', ''), Input::get('newpassword', '')))
				return Redirect::to('login')->with('success', 'Ihr Passwort wurde zurückgesetzt!');
			else
				return Redirect::to('login')->with('error', 'Das Zurücksetzten ist fehlgeschlagen!');
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
			return Redirect::to('forgotpassword')->with('error', 'Alles falsch!');
		}
	}
}
