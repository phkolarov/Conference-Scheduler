<?php


namespace controllers;

use annotationParser\annotationParser;
use controllers\defaultControllers\CustomRouteController;

include("viewhelpers\mainMenu.php");
include("annotationParser\annotationParser.php");
include("CustomRouteController.php");

class BaseController{


    public static function ControllerSeeker($ctrl,$act,$param){



        $controller = $ctrl;
        $action = $act;
        $parameters = $param;
        //Annotation parser is check for any valid annotation and return correct controller and action if it's need it;

        $annotationParameters = annotationParser::CheckAnnotations($controller,$action);
        $annotations = false;
        if(!empty($annotationParameters)){

            $controller = $annotationParameters["controller"];
            $action = $annotationParameters["action"];
            $annotations = true;
        }
        $customRouteParameters = CustomRouteController::routeChecker($controller,$action);


        if(!$annotations && !empty($customRouteParameters)){


            $controller = $customRouteParameters["controller"];
            $action = $customRouteParameters["action"];


        }
        $controllerPath = "controllers\\defaultControllers\\". ucfirst($controller)."Controller";


      if(file_exists($controllerPath. ".php")){



          spl_autoload_register(function($class){


              require_once($class.".php");
          });

          \views\View::$controllerName =$controller;
          \views\View::$actionName = $action;

          $currentController = new $controllerPath;

          if(true){

              \MainMenuHelper::$menuitems = array("TestK" => "TestV");
          }

          if(method_exists($currentController,$action)){

              call_user_func_array(array($currentController,$action),array($parameters));
          }




      }else{

        throw new \HttpException("NOT FOUND ROUTE!");
      }




    }

}