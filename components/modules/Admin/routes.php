<?php

// All routes related to the admin system

Route::group(array('prefix' => 'admin'), function ()
{
    Route::get('/', function()
    {
        return Redirect::to('admin/dashboard');
    });

    Route::controller('frontend', 'Cmex\Modules\Admin\Controller\Frontend');

    Route::resource('user', 'Cmex\Modules\Admin\Controller\User');
    Route::resource('group', 'Cmex\Modules\Admin\Controller\Group');

    Route::controller('dashboard', 'Cmex\Modules\Admin\Controller\Dashboard');

    Route::get('media', 'Cmex\Modules\Admin\Controller\Media@index');
    Route::get('media/{path}', 'Cmex\Modules\Admin\Controller\Media@show')->where('path', '[A-Za-z0-9/.]+');

    // Load module admin routes
    $modules = App::make('admin.modules');

    foreach ($modules as $module) {
        Route::controller(strtolower($module), 'Cmex\Modules\\'.$module.'\Controller\Admin');
    }

});