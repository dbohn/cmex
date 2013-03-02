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

Route::get('test/test', function() { 
    
    $testclass = "Cmex\\Chunks\\Container\\Standard";

    $prefix = "Cmex\\Chunks\\";

    var_dump(substr_compare($testclass, $prefix, 0, strlen($prefix)));

    return substr($testclass, strlen($prefix));
});

// Enable access to the (virtual) filesystem
Route::get('file/{option}/{path}', 'MediaController@resolveFile')->where('path', '[A-Za-z0-9/.]+');
