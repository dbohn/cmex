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
        if(!Sentry::check()) {
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
        
                if($user = Sentry::authenticate($credentials)) {
                    return Redirect::to('admin/overview');
                } else {
                    return Redirect::to('login')->with('error', 'Falsche Logindaten!');
                }
            } catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
                return Redirect::to('login')->with('error', 'Der Benutzer wurde nicht gefunden!');
            } catch (Cartalyst\Sentry\Users\LoginRequiredException $e) {
                return Redirect::to('login')->with('error', 'Es muss ein Login-Feld angegeben werden!');
            } catch (Cartalyst\Sentry\Users\UserNotActivatedException $e) {
                return Redirect::to('login')->with('error', 'Der Nutzer ist nicht aktiviert!');
            } catch (Exception $e) {
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
        if(Sentry::check()) {
            Sentry::logout();
        }

        return Redirect::to('login')->with('success', 'Erfolgreich abgemeldet!');
    }

    public function userCreator() {
        try
        {
            $user = Sentry::getUserProvider()->create(array(
                'name'          =>  'admin',
                'email'         => 'admin@admin.com',
                'password'      => 'admin',
                'first_name'    => 'David',
                'last_name'     => 'Bohn',
                'permissions' => array(
                    'test'  => 1,
                    'other' => -1,
                    'admin' => 1,
                )
            ));
        }
        catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
        {
            echo 'Login field required.';
        }
        catch (Cartalyst\Sentry\Users\UserExistsException $e)
        {
            echo 'User with login already exists.';
        }
        catch (Cartalyst\Sentry\Users\InvalidPermissionsException $e) {
            echo 'Not enough permissions!';
        }
        catch (Exception $e) {
            echo 'Exception!';
            echo $e->getMessage();
        }
    }
}
