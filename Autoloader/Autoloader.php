<?php

namespace Autoloader;

class Autoloader
{
    public static function init()
    {
        spl_autoload_register(function ($class) {


            if (file_exists($class . ".php")) {


                var_dump('sd');
                require_once($class . ".php");

            }


        });
    }
}