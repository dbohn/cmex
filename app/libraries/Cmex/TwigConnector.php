<?php

namespace Cmex;

use TwigBridge\Extension;
use Twig_Environment;
use Illuminate\Foundation\Application;
use Twig_Function_Function;

class TwigConnector extends Extension
{
    private $registeredFunctions = array("full_username","chunk", "asset", "path");

    public function __construct(Application $app, Twig_Environment $twig)
    {
        parent::__construct($app, $twig);
        // TODO: this callback should use a subset of functions for security reasons!
        $twig->registerUndefinedFunctionCallback(function ($name) {
            if(in_array($name, $this->registeredFunctions)) {
                return new Twig_Function_Function($name);
            }
            /*if (function_exists($name)) {
                return new Twig_Function_Function($name);
            }*/

            return false;
        });
    }

    public function getName()
    {
        return 'TwigConnector';
    }
}