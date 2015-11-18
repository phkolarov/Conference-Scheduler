<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 12.11.2015 г.
 * Time: 11:45 ч.
 */

namespace annotationParser;

include_once("annotations\CRUD.php");
include_once("annotations\Authorize.php");
include_once("annotations\Admin.php");
include_once("annotations\AnnotationRoute.php");

use annotationParser\annotations\Admin;
use annotationParser\annotations\Authorize;
use annotationParser\annotations\CRUD;
use annotationParser\annotations\AnnotationRoute;
use \ReflectionException;

class annotationParser
{


    public static function CheckAnnotations($controller, $action)
    {


        $defaultControllerPath = "controllers\\defaultControllers\\";
        $annotationsArray = [];


        //If file exist
        if (file_exists($defaultControllerPath . $controller . "Controller.php")) {


            include_once($defaultControllerPath . $controller . "Controller.php");

            $controllerName = $defaultControllerPath . $controller . "Controller";

            $currentController = new $controllerName;

            $reflection = new \ReflectionClass($currentController);


            try {
                $currentMethod = $reflection->getMethod($action);
                $docBlock = $currentMethod->getDocComment();
                $patternController = "/Route\(([A-Za-z]+)\/([A-Za-z]+)\)/";

                preg_match($patternController,$docBlock,$haveRoute);

                if(count($haveRoute) > 0){

                    throw new \Exception("The current route it's have a custom");
                }

                $pattern = '/\* @(.*)\n/';

                preg_match_all($pattern, $docBlock, $machedAnnotations);

                if (isset($machedAnnotations[1])) {

                    foreach ($machedAnnotations[1] as $item) {

                        if (!in_array($item, $annotationsArray)) {
                            $annotationsArray[] = $item;
                        }
                    }
                }

                //AFTER GET ALL ANNOTATIONS SET IT ON ANNOTATION EXTRACTOR

                self::annotationExtractor($annotationsArray);


            } catch (ReflectionException $ex) {

                throw new \Exception("This path is not correct!!!");
            }


        } else if (!file_exists($defaultControllerPath . $controller . "Controller.php")) {
            //If file not exist

            self::timeSaver();

            $correctRoutesByAnnotationRoute = AnnotationRoute::loadRouter($controller,$action);

            $correctController = new $correctRoutesByAnnotationRoute["Controller"];

           try{
               $reflection = new \ReflectionClass($correctController);
               $reflectionClassName = $reflection->getName();
               $patternToGetNameOfClass = '/[A-Za-z]+\\\[A-Za-z]+\\\([A-Za-z]+)/';
               $correctControllerActionParameters = [];
               $method = $reflection->getMethod($correctRoutesByAnnotationRoute["Action"]);

               preg_match($patternToGetNameOfClass,$reflectionClassName,$className);

               $className = str_replace("Controller", "", $className);


               $correctControllerActionParameters["controller"] = $className[1];
               $correctControllerActionParameters["action"] = $method->getName();

               if($method){

                   $docBlock = $method->getDocComment();

                   $patternController = "/Route\(([A-Za-z]+)\/([A-Za-z]+)\)/";

                   preg_match($patternController,$docBlock,$haveRoute);

                   $pattern = '/\* @(.*)\n/';

                   preg_match_all($pattern, $docBlock, $machedAnnotations);

                   if (isset($machedAnnotations[1])) {

                       foreach ($machedAnnotations[1] as $item) {

                           if (!in_array($item, $annotationsArray)) {
                               $annotationsArray[] = $item;
                           }
                       }
                   }

                   //AFTER GET ALL ANNOTATIONS SET IT ON ANNOTATION EXTRACTOR

                   self::annotationExtractor($annotationsArray);

                   return $correctControllerActionParameters;
               }
           }catch (ReflectionException $ex) {

               throw new \Exception("This path is not correct!!!");
           }

            echo "<br>";



        }


    }


    private static function annotationExtractor($annotationArray)
    {


        if (count($annotationArray) > 0) {

            foreach ($annotationArray as $item) {


                $pattern = '/Route\([A-Za-z]+\/[A-Za-z]+\)/';
                $item = trim($item);

                preg_match_all($pattern, $item, $matchRoute);

                if (count($matchRoute) > 1) {
                    throw new \Exception("This route have annotation please add correct route!!!");
                } else {

                    //CHECK REQUEST METHOD
                    CRUD::CRUDChecker($item);

                    //CHECK FOR AUTHORIZE
                    if ($item == "Authorize") {

                        Authorize::checkForAuthorize();

                    //CHECK FOR ADMIN ROLE
                    } else if ($item == "Admin") {

                        Admin::checkAdminRole();
                    }


                }
            }
        }

    }

    private static function timeSaver(){
        //!isset($_COOKIE["timerSettt"])
        if (true) {
            $time2 = strtotime("+1 minutes");
            $_COOKIE["timerSettt"] = $time2;
            setcookie("timerSettt", $time2);

            AnnotationRoute::saveCorrectDataWithReflection();

        } else {

            $time = strtotime('now');
            $setedTime = (int)$_COOKIE["timerSettt"];

            if ($time > $setedTime) {
                $time = strtotime("+1 minutes");
                $_COOKIE["timerSettt"] = $time;
                setcookie("timerSettt", $time);

                AnnotationRoute::saveCorrectDataWithReflection();

            }

        }

    }










}