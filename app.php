<?php

declare(strict_types=1);
use controllers\BaseController;
include_once('controllers\BaseController.php');

class app
{


    public static $uri;
    public static $controller;
    public static $action;
    public static $parameters;


    public function __construct($uri){


        $this::$uri = $uri;
        $requestUri = explode("/", $uri);

            $controller =  array_shift($requestUri);
            $this::$controller = ($controller == "index.php") ? "index" : $controller;

            $action = array_shift($requestUri);
            $this::$action = ($action == "") || ($action == null)? "index" : $action;

            $this::$parameters = $requestUri;
    }

        public function run(){

            BaseController::controllerChecker(self::$controller,self::$action,self::$parameters);
        }
}