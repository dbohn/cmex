<?php

namespace Cmex\Modules\Login\Controller;

use BaseController;
use Authentication;
use View;
use Redirect;
use Input;
use Log;
use URL;
use Session;
use Cartalyst\Sentry\Users;
use Exception;

class LoginLogoff extends BaseController
{
    /**
     * login 
     * shows Loginform
     *
     * @access public
     * @return void
     */
    public function login()
    {
        if (!Authentication::check()) {
            return View::make('Login::loginform');
        } else {
            return Redirect::to('admin');
        }
    }

    /**
     * auth
     * Handles authentication 
     * 
     * @access public
     * @return void
     */
    public function auth()
    {
        if (Input::has('name') && Input::has('password')) {
            try {
                $credentials = array(
                    'email' => Input::get('name'),
                    'password' => Input::get('password')
                );

                $rememberMe = (Input::has("remember-me") && Input::get("remember-me") == "remember-me") ? true : false;
        
                if ($user = Authentication::authenticate($credentials, $rememberMe)) {
                    // FIX THAT SECURITY ISSUE! :D
                    return Redirect::to(URL::previous());
                } else {
                    return Redirect::to('login')->with('error', 'Falsche Logindaten!')->withInput();
                }
            } catch (Users\UserNotFoundException $e) {
                Log::info($e->getMessage());
                return Redirect::to('login')->with('error', 'Der Benutzer wurde nicht gefunden!')->withInput();
            } catch (Users\LoginRequiredException $e) {
                Log::info($e->getMessage());
                return Redirect::to('login')
                    ->with('error', 'Es muss ein Login-Feld angegeben werden!' . $e->getMessage())->withInput();
            } catch (Users\UserNotActivatedException $e) {
                Log::info($e->getMessage());
                return Redirect::to('login')->with('error', 'Der Nutzer ist nicht aktiviert!')->withInput();
            } catch (Exception $e) {
                Log::error($e->getMessage());
                return Redirect::to('login')->with('error', $e->getMessage())->withInput();
            }
            
        } else {
            return Redirect::to('login')->with('error', 'Zur Anmeldung werden Benutzername und Passwort benötigt!')->withInput();
        }
    }

    /**
     * logoff 
     * Handles logout
     *
     * @access public
     * @return void
     */
    public function logoff()
    {
        if (Authentication::check()) {
            Authentication::logout();
        }

        return Redirect::to('login')->with('success', 'Erfolgreich abgemeldet!');
    }
}
