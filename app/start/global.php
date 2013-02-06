<?php

/*
|--------------------------------------------------------------------------
<<<<<<< HEAD
=======
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/controllers',
	app_path().'/models',

));

/*
|--------------------------------------------------------------------------
>>>>>>> 106d3b7287108e168af39da737102cc8f8859370
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

Log::useDailyFiles(__DIR__.'/../storage/logs/log.txt');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

// App::missing(function($exception) {
// 	if(View::exists(Config::get('cmex.template').".".Config::get('cmex.error404_default'))) {
// 		return View::make(Config::get('cmex.template').".".Config::get('cmex.404view'));
// 	} else {
// 		return View::make('error404');
// 	}
// });

App::error(function(Symfony\Component\HttpKernel\Exception\HttpException $exception) {
	try {
		// Try loading templates default view
		$view = View::make(Config::get('cmex.template').".".Config::get('cmex.error404_default'));

		$response = Response::make($view, 404);

		return $response;
	} catch(InvalidArgumentException $e) {
		// otherwise load cmex-default
		$view = View::make('error404');

		$response = Response::make($view, 404);

		return $response;
	}
});

App::error(function(Exception $exception, $code)
{
	Log::error($exception);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require __DIR__.'/../filters.php';