<?php

// Authentication routes
Route::get('login', array('as' => 'login', 'uses' => 'Cmex\Modules\Login\Controller\LoginLogoff@login'));

Route::get('logoff', 'Cmex\Modules\Login\Controller\LoginLogoff@logoff');
Route::get('logout', 'Cmex\Modules\Login\Controller\LoginLogoff@logoff');

Route::post('doLogin', 'Cmex\Modules\Login\Controller\LoginLogoff@auth');

// Password routes
Route::get('forgotpassword', 'Cmex\Modules\Login\Controller\Swordfish@forgotpassword');
Route::get('newpassword/{id}', 'Cmex\Modules\Login\Controller\Swordfish@newpassword');

Route::post('doReset', 'Cmex\Modules\Login\Controller\Swordfish@doReset');
Route::post('doNewpw/{id}', 'Cmex\Modules\Login\Controller\Swordfish@doNewpw');