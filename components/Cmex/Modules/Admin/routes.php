<?php

// All routes related to the admin system
Route::get('admin/', function()
{
    return Redirect::to('admin/dashboard');
});

Route::group(array('prefix' => 'admin'), function ()
{

    Route::controller('frontend', 'Cmex\Modules\Admin\Controller\Frontend');

    Route::get('notifications', array('before' => 'auth', function () {
        $user = Authentication::getUser();
        $notify = App::make('Cmex\Libraries\Notifications\Environment');
        $collection = $notify->forUser($user->id);

        return $collection;
    }));

    Route::resource('user', 'Cmex\Modules\Admin\Controller\User');
    Route::resource('group', 'Cmex\Modules\Admin\Controller\Group');

    Route::controller('dashboard', 'Cmex\Modules\Admin\Controller\Dashboard');

    Route::get('media', 'Cmex\Modules\Admin\Controller\Media@index');
    Route::get('media/{path}', 'Cmex\Modules\Admin\Controller\Media@show')->where('path', '[A-Za-z0-9/.]+');

    Route::get('{module}', function ($module)
    {
        return $module;
    });

});