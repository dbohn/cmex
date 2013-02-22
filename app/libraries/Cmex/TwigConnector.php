<?php

namespace Cmex;

use TwigBridge\Extension;
use Twig_Environment;
use Illuminate\Foundation\Application;
use Twig_Function_Function;

class TwigConnector extends Extension
{
    public function __construct(Application $app, Twig_Environment $twig)
    {
        parent::__construct($app, $twig);

        $twig->registerUndefinedFunctionCallback(function ($name) {
            if (function_exists($name)) {
                return new Twig_Function_Function($name);
            }

            return false;
        });
    }

    public function getName()
    {
        return 'TwigConnector';
    }
}