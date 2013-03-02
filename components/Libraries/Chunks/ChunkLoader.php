<?php

namespace Cmex\Libraries\Chunks;

/**
 * This class is responsible for loading
 * chunks. Therefore it has a list of existing
 * chunks, which is expanded by need.
 */
class ChunkLoader {
    protected static $base = "";

    protected static $registered = false;

    public static function setBase($base)
    {
        self::$base = $base;
    }

    public static function load($class)
    {

        if($class[0] == '\\') $class = substr($class, 1);

        $prefix = "Cmex\\Chunks\\";
        $preflength = strlen($prefix);

        if(substr_compare($class, $prefix, 0, $preflength) === 0) {
            // is in Cmex\Chunks, search it!
            $class = substr($class, $preflength);
            $classPath = self::$base . str_replace(array('\\', '_'), DIRECTORY_SEPARATOR, $class) . ".php";

            require_once $classPath;

            return true;
        }
    }

    public static function register()
    {
        if(!self::$registered) {
            // As there are quite a lot of chunks, we prepend it to the
            // autoload queue as it is easy for this loader to decline
            // responsibility, but it takes long for it to work completely
            spl_autoload_register(array('\Cmex\Libraries\Chunks\ChunkLoader', 'load'), true, true);

            self::$registered = true;
        }
    }
}