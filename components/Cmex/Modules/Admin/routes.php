<?php

// All routes related to the admin system
Route::group(array('prefix' => 'admin'), function()
{
    Route::get('/', function()
    {
        return Redirect::to('admin/dashboard');
    });

    Route::resource('user', 'Cmex\Modules\Admin\Controller\User');
    Route::resource('group', 'Cmex\Modules\Admin\Controller\Group');

    Route::get('dashboard', 'Cmex\Modules\Admin\Controller\Dashboard@handle');

    Route::get('media', 'Cmex\Modules\Admin\Controller\Media@index');
    Route::get('media/{path}', 'Cmex\Modules\Admin\Controller\Media@show')->where('path', '[A-Za-z0-9/.]+');

    Route::get('{module}', function($module)
    {
        return $module;
    });

});