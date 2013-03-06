<?php

namespace Cmex\Modules\Login\Controller;

use BaseController, Authentication, View, Redirect, Input, Log, Cartalyst\Sentry\Users, Exception;

class LoginLogoff extends BaseController {
    /**
     * login 
     * shows Loginform
     *
     * @access public
     * @return void
     */
    public function login() {
        if(!Authentication::check()) {
            return View::make('Login::loginform');
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
            } catch (Users\UserNotFoundException $e) {
                Log::info($e->getMessage());
                return Redirect::to('login')->with('error', 'Der Benutzer wurde nicht gefunden!');
            } catch (Users\LoginRequiredException $e) {
                Log::info($e->getMessage());
                return Redirect::to('login')->with('error', 'Es muss ein Login-Feld angegeben werden!' . $e->getMessage());
            } catch (Users\UserNotActivatedException $e) {
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
}
