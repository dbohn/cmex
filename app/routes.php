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

Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{
    Route::get('/', function()
    {
        return Redirect::to('admin/dashboard');
    });

    Route::resource('user', 'AdminUserController');

    Route::get('dashboard', 'AdminDashboardController@handle');

    Route::get('{module}', function($module)
    {
        return $module;
    });

});

Route::get('login', array('as' => 'login', 'uses' => 'LoginController@login'));

Route::get('logoff', 'LoginController@logoff');
Route::get('logout', 'LoginController@logoff');

Route::post('doLogin', 'LoginController@auth');

Route::any('{page}', 'PageController@handlePageRequest');

Route::get('/', 'PageController@showHomePage');
