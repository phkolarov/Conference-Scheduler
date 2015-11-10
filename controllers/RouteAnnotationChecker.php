<?php
/**
 * Created by PhpStorm.
 * User: Phill
 * Date: 10/7/2015
 * Time: 8:52 PM
 */
declare(strict_types=1);

namespace controllers;


class RouteAnnotationChecke
{


    public static $annotationController;
    public static $annotationAction;

    public static function checkAnnotations($controllerName,$actionName)
    {

        $defaultControllersPath = 'controllers\\defaultControllers';
        $areaControllersPath = 'areas\\areaControllers';
        $defaultControllersFileNames = scandir($defaultControllersPath);
        $areaControllersFileNames = scandir($areaControllersPath);

        foreach($defaultControllersFileNames as $fileName){

            spl_autoload_register(function($class){
                $classPath = $class.".php";
                if(file_exists($classPath)){}

                require_once($classPath);
            });

            if(strpos($fileName, ".php")> 0){

                $reflection = new \ReflectionClass("controllers\\defaultControllers\\".basename($fileName,".php"));
                $methodsOfCurrentClass = $reflection->getMethods();

                foreach($methodsOfCurrentClass as $method){

                    $pattern = '/@Route\(\"(\w+)\/(\w+)/';

                    $methodDoc =  $method->getDocComment();


                    if($methodDoc){

                        $currentClassName = lcfirst(basename($fileName,"Controller.php"));
                        $currentMethodName = $method->getName();



                        var_dump($currentMethodName);
                        var_dump("-----------");
                        preg_match($pattern ,$methodDoc,$matches);
                        self::$annotationController = $matches[1];
                        self::$annotationAction = $matches[2];


                        if($controllerName == $matches[1] && $actionName == $matches[2]){

                            $annotationArray = [];

                            $annotationArray[] = $currentClassName;
                            $annotationArray[] = $currentMethodName;


                            return $annotationArray;
                        }
                       if(lcfirst($controllerName) == $currentClassName && $actionName == $currentMethodName){

                           var_dump($currentClassName);
                           throw new \ErrorException("This route not exist");
                       }
                    }



                }
            }

        }
        foreach($areaControllersFileNames as $fileName){

            spl_autoload_register(function($class){
                $classPath = $class.".php";
                if(file_exists($classPath)){}

                require_once($classPath);
            });

            if(strpos($fileName, ".php")> 0){

                $reflection = new \ReflectionClass("areas\\areaControllers\\".basename($fileName,".php"));
                $methodsOfCurrentClass = $reflection->getMethods();

                foreach($methodsOfCurrentClass as $method){

                    $pattern = '/@Route\(\"(\w+)\/(\w+)/';

                    $methodDoc =  $method->getDocComment();
                    if($methodDoc){

                        $currentClassName = lcfirst(basename($fileName,"Controller.php"));
                        $currentMethodName = $method->getName();

                        preg_match($pattern ,$methodDoc,$matches);

                        self::$annotationController = $matches[1];
                        self::$annotationAction = $matches[2];

                        if($controllerName == $matches[1] && $actionName == $matches[2]){

                            $annotationArray = [];

                            $annotationArray[] = $currentClassName;
                            $annotationArray[] = $currentMethodName;


                            var_dump("KAKO!");
                            var_dump($annotationArray);

                            return $annotationArray;
                        }


                        if($controllerName == $currentClassName && $actionName == $currentMethodName){

                            throw new \ErrorException("This route not exist!");
                        }
                    }



                }
            }

        }

    }
}