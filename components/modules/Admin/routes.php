<?php

// All routes related to the admin system
Route::group(array('prefix' => 'admin', 'before' => 'auth'), function()
{
    Route::get('/', function()
    {
        return Redirect::to('admin/dashboard');
    });

    Route::resource('user', 'Cmex\Modules\Admin\AdminUserController');

    Route::get('dashboard', 'Cmex\Modules\Admin\AdminDashboardController@handle');

    Route::get('media', 'Cmex\Modules\Admin\AdminMediaController@index');
    Route::get('media/{path}', 'Cmex\Modules\Admin\AdminMediaController@show')->where('path', '[A-Za-z0-9/.]+');

    Route::get('{module}', function($module)
    {
        return $module;
    });

});