<?php

namespace Cmex\Libraries\System;

/**
 * CmexLoader is the responsible autoloader for cmex! Modules and Chunks
 * Based on the proposed autoloader by pmjones in his PHP-FIG Proposal on
 * Package Autoloading:
 * https://groups.google.com/forum/?fromgroups=#!topic/php-fig/qT7mEy0RIuI
 */
class CmexLoader
{
    protected static $paths = array();

    protected static $registered = false;

    public static function addNamespace($namespace, $path)
    {
        $path = rtrim($path, DIRECTORY_SEPARATOR);

        self::$paths[$namespace][] = $path;
    }

    public static function load($class)
    {
        $name = '';

        $parts = explode('\\', $class);
        
        while ($parts) {
            $name = DIRECTORY_SEPARATOR . array_pop($parts) . $name;

            $ns = implode('\\', $parts);

            if (!isset(self::$paths[$ns])) {
                continue;
            }

            foreach (self::$paths[$ns] as $path) {
                $file = $path . $name . ".php";

                if (is_readable($file)) {
                    require $file;

                    return true;
                }
            }
        }

        return false;
    }

    public static function register($prepend = false)
    {
        if (!self::$registered) {
            spl_autoload_register(array('\Cmex\Libraries\System\CmexLoader', 'load'), true, $prepend);

            self::$registered = true;
        }
    }
}
