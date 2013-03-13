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

// Enable access to the (virtual) filesystem
Route::get('file/{option}/{path}', 'MediaController@resolveFile')->where('path', '[A-Za-z0-9/.]+');

Route::any('{page}', 'Cmex\Modules\Page\Controller\PageController@handlePageRequest');

Route::get('/', 'Cmex\Modules\Page\Controller\PageController@showHomePage');
