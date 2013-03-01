<?php

// Authentication routes
Route::get('login', array('as' => 'login', 'uses' => 'Cmex\Modules\Login\LoginController@login'));

Route::get('logoff', 'Cmex\Modules\Login\LoginController@logoff');
Route::get('logout', 'Cmex\Modules\Login\LoginController@logoff');

Route::post('doLogin', 'Cmex\Modules\Login\LoginController@auth');

// Password routes
Route::get('forgotpassword', 'Cmex\Modules\Login\LoginController@forgotpassword');
Route::get('newpassword/{id}', 'Cmex\Modules\Login\LoginController@newpassword');

Route::post('doReset', 'Cmex\Modules\Login\LoginController@doReset');
Route::post('doNewpw/{id}', 'Cmex\Modules\Login\LoginController@doNewpw');