<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('admin/', function() {
    return Redirect::to('admin/overview');
});

Route::any('/admin/{module}', array('before' => 'auth', function($module) {
    return "Administration - Sie sind eingeloggt als: ".Auth::user()->getFullName() . "<a href='".URL::to('/')."'>Startseite</a>";
}));

Route::get('createuser', function() {
	try
	{
	    $user = Sentry::getUserProvider()->create(array(
	    	'name'			=>	'admin',
	        'email'    		=> 'admin@admin.com',
	        'password' 		=> 'admin',
	        'first_name'	=> 'David',
	        'last_name'		=> 'Bohn',
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
});

Route::get('login', array('as' => 'login', 'uses' => 'LoginController@login'));

Route::get('logoff', 'LoginController@logoff');
Route::get('logout', 'LoginController@logoff');

Route::post('doLogin', 'LoginController@auth');

Route::any('{page}', 'PageController@handlePageRequest');

Route::get('/', 'PageController@showHomePage');