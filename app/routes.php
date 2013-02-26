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

// All routes related to the admin system
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{
    Route::get('/', function()
    {
        return Redirect::to('admin/dashboard');
    });

    Route::resource('user', 'AdminUserController');

    Route::get('dashboard', 'AdminDashboardController@handle');

    Route::get('media', 'AdminMediaController@handle');

    Route::get('{module}', function($module)
    {
        return $module;
    });

});

// Authentication routes
Route::get('login', array('as' => 'login', 'uses' => 'LoginController@login'));

Route::get('logoff', 'LoginController@logoff');
Route::get('logout', 'LoginController@logoff');

Route::post('doLogin', 'LoginController@auth');

// Enable access to the (virtual) filesystem
Route::get('file/{option}/{path}', 'MediaController@resolveFile')->where('path', '[A-Za-z0-9/.]+');

// Default route for any pages
Route::any('{page}', 'PageController@handlePageRequest');

Route::get('/', 'PageController@showHomePage');
