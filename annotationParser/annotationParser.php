<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 12.11.2015 г.
 * Time: 11:45 ч.
 */

namespace annotationParser;
use annotationParser\annotations\Authorize;
use annotationParser\annotations\CRUD;


class annotationParser
{


        public static function CheckAnnotations($controller, $action){


                $defaultControllerPath = "controllers\\defaultControllers\\". ucfirst($controller). "Controller";
                $annotationsArray = [];

            if(file_exists($defaultControllerPath. ".php")){

                spl_autoload_register(function($class){

                    require_once($class.".php");
                });

                $currentController = new $defaultControllerPath;

                $reflecton = new \ReflectionClass($currentController);

                $methods = $reflecton->getMethods();


                //Find current method in called class and get DocBlock with reflection
                //To get all annotations and put it into array;

                foreach ($methods as $method) {


                    if(lcfirst($method->getName()) == lcfirst($action)){

                        $docBlock = $method->getDocComment();
                        $pattern = '/\* @(.*)\n/';



                        preg_match_all($pattern,$docBlock,$maches);


                        foreach ($maches as $item) {

                            //ADD UNIQUE ANNOTATIONS TO ARRAY
                            if (!in_array($item,$annotationsArray)){
                                $annotationsArray[] = $item;

                            }
                        }

                    }
                }



                //FIRST CHECK $Annotations array is not empty to continue with program logic

                if(!empty($annotationsArray[0])){

                    foreach($annotationsArray[1] as $annotation){

                        $annotation = trim($annotation);
                        $pattern = '/(Route)\((\w+)\/(\w+)/';
                        preg_match($pattern,$annotation,$routeMatches);

                        $customController = "";
                        $customAction = "";

                        if($routeMatches){

                            $annotation = $routeMatches[1];
                            $customController = $routeMatches[2];
                            $customAction = $routeMatches[3];
                        }


                        CRUD::CRUDChecker($annotation);

                        if($annotation == "Authorize"){

                            return Authorize::checkForAuthorize();
                        }else if($annotation == "Admin"){

                            //TO DO.....
                        }else if($annotation == "Route"){


                        }

                    }
                }
            }






        }
}