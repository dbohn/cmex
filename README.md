#cmex! - next generation

This is a CMS based on Laravel 4 aka Illuminate.

It focuses on providing a consistent interface for adding "chunks" to a page, which are first of all just a piece of data, but which can be lifted up to complex forms, blogs etc. by your chunk-class.
By now it's in an early stage, but under active development.

## Requirements

As this CMS is based on Laravel 4 it needs at least PHP 5.3.
It should work with all databases supported by Laravel 4, but currently only MySQL is tested.

## Installation

I assume, that you have a global installation of composer.

Just type:
```
composer install
```

This might take a couple of minutes as composer has to fetch all illuminate components.

After this process has finished, type:
```
php artisan migrate --seed
```

and you should be good to go!