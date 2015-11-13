<?php


include("controllers/BaseController.php");
include("views/View.php");

use controllers\BaseController;

class app
{


    public static $uri;
    public static $controller;
    public static $action;
    public static $parameters;


    // THe constructor explore URI to controller,action and parameters if exist and
    //set it to ControllerSeeker hwo find the current controller;

    public function __construct($uri){

        $this::$uri = $uri;
        $requestUri = explode("/", $uri);

            $controller =  array_shift($requestUri);
            $this::$controller = ($controller == "index.php") ? "home" : $controller;

            $action = array_shift($requestUri);
            $this::$action = ($action == "") || ($action == null)? "index" : $action;
            $this::$parameters = $requestUri;


    }

        public function run(){

            BaseController::ControllerSeeker(self::$controller,self::$action,self::$parameters);
        }
}