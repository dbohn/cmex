<?php

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = urldecode($uri);

<<<<<<< HEAD
$requested = __DIR__.'/public'.$uri;
=======
$paths = require __DIR__.'/bootstrap/paths.php';

$requested = $paths['public'].$uri;
>>>>>>> 79d18a3122e4211b3f8b32587df34cae20bb070c

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if ($uri !== '/' and file_exists($requested))
{
	return false;
}

<<<<<<< HEAD
require_once(__DIR__ . '/public/index.php');
=======
require_once $paths['public'].'/index.php';
>>>>>>> 79d18a3122e4211b3f8b32587df34cae20bb070c
