<?php


namespace controllers;

class BaseController{


    public static function ControllerSeeker($controller,$action,$parameters){


      $controllerPath = "controllers\\defaultControllers\\". ucfirst($controller)."Controller";


      if(file_exists($controllerPath. ".php")){



          spl_autoload_register(function($class){


              require_once($class.".php");
          });


          $currentController = new $controllerPath;

          if(method_exists($currentController,$action)){

              call_user_func_array(array($currentController,$action),array($parameters));
          }




      }else{

        throw new \HttpException("NOT FOUND ROUTE!");
      }




    }

}