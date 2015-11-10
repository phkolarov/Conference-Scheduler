<?php
/**
 * Created by PhpStorm.
 * User: Phill
 * Date: 10/7/2015
 * Time: 7:14 PM
 */
declare(strict_types=1);

namespace controllers;

use controllers\defaultControllers\IndexController;
use controllers\DefaultRouterController;
use controllers\AreaController;
use controllers\AnnotationController;

include('DefaultRouterController.php');
include('AreaController.php');
include('CustomRouteController.php');
include('RouteAnnotationChecker.php');

class BaseController
{


    public static function controllerChecker(string $ctrl,string $action,$parameters)
    {

        if(!isset($_SESSION['username'])){
            $controller = "index";
            $action = "login";
        }

        //CHECK FOR ANNOTATIONS FIRST PRIORITY

        $annotationArray = RouteAnnotationChecke::checkAnnotations($ctrl,$action);
        $annotation = false;
        if(count($annotationArray)>= 2){

            $annotation = true;
            $controller = $annotationArray[0];
            $action = $annotationArray[1];
        }
        //................................................................................

        //CHECK FOR CUSTOM ROUTES AND RETURN EXISTED SECOND PRIORITY

       if(!$annotation){

           $controller = CustomRouteController::routeChecker($ctrl);
       }


        //................................................................................

        //ELSE RUN DEFAULT ROUTE SYSTEM


        $controllerName = "controllers\\defaultControllers\\".ucfirst($controller)."Controller";

        if(!file_exists($controllerName.'.php')){
            $controllerName="controllers\\defaultControllers\\IndexController";
        };

        //CHECK FOR AREAS
        $areaChecker = AreaController::areaChecker($controller);

        if($areaChecker){
            $controllerName =  "areas\\areaControllers\\".ucfirst($controller)."Controller";
        }



        spl_autoload_register(function($class){
            $controllerPath = $class.".php";
            if(file_exists($controllerPath)){
                require_once($controllerPath);
            };
        }
        );

        $loadedController = new $controllerName();

        if(method_exists($loadedController,$action)){

            call_user_func_array(array($loadedController,$action),array($parameters));
        }


    }

}