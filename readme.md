#cmex! - next generation

This is a CMS based on Laravel 4 aka Illuminate.

It focuses on providing a consistent interface for adding "chunks" to a page, which are first of all just a piece of data, but which can be lifted up to complex forms, blogs etc. by your chunk-class.
By now it's in an early stage, but under active development.

## Requirements

As this CMS is based on Laravel 4 it needs at least PHP 5.3.
It should work with all databases supported by Laravel 4, but currently only MySQL is tested.
Ok, right now it should only work with MySQL as we do have a more complex query in the Menu chunk which is not expected to work on other architectures.

## Installation

We assume, that you have a global installation of composer.

Just run in this directory:
```
composer install
```

This might take a couple of minutes as composer has to fetch all Laravel components and dependencies.

After this process has finished, modify the file app/config/database.php to match your database config and run the following commands in your shell:
```
php artisan migrate
php artisan migrate --package=cartalyst/sentry
php artisan db:seed
```

and you should be good to go!
Just navigate to the public directory of your cmex! installation.
There's also a shared_hosting_htaccess.txt, which you can rename to .htaccess, if you don't want to navigate into the public folder.
