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

use annotationParser\annotations\Admin;
use annotationParser\annotations\Authorize;
use annotationParser\annotations\CRUD;
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
                $pattern = '/\* @(.*)\n/';

                preg_match_all($pattern, $docBlock, $machedAnnotations);

                if (isset($machedAnnotations[1])) {

                    foreach ($machedAnnotations[1] as $item) {

                        if (!in_array($item, $annotationsArray)) {
                            $annotationsArray[] = $item;
                        }
                    }
                }

                self::annotationExtractor($annotationsArray);


            } catch (ReflectionException $ex) {

                throw new \Exception("This path is not correct!!!");
            }


        } else if (!file_exists($defaultControllerPath . $controller . "Controller.php")) {
            //If file not exist

            self::setRouteSettings($controller,$action);
            echo "<br>";

            if (!isset($_COOKIE["timerSettt"])) {
                $time2 = strtotime("+1 minutes");

                $_COOKIE["timerSettt"] = $time2;
                setcookie("timerSettt", $time2);

                self::setRouteSettings($controller,$action);
                self::loadRouteSettings();

            } else {

                $time = strtotime('now');
                $setedTime = (int)$_COOKIE["timerSettt"];

                if ($time > $setedTime) {




                    $time = strtotime("+1 minutes");

                    $_COOKIE["timerSettt"] = $time;
                    setcookie("timerSettt", $time);


                    var_dump('maikooo');
                }

            }


        }


    }


    private static function annotationExtractor($annotationArray)
    {


        if (count($annotationArray) > 1) {

            foreach ($annotationArray as $item) {

                $pattern = '/Route\([A-Za-z]+\/[A-Za-z]+\)/';
                $item = trim($item);

                preg_match_all($pattern, $item, $matchRoute);

                if (count($matchRoute) > 1) {

                    var_dump($matchRoute);

                    throw new \Exception("This route have annotation please add correct route!!!");
                } else {

                    CRUD::CRUDChecker($item);

                    if ($item == "Authorize") {
                        Authorize::checkForAuthorize();
                    } else if ($item == "Admin") {
                        Admin::checkAdminRole();
                    }


                }
            }
        }

    }

    private static function setRouteSettings($customController,$customAction){


        $defaultControllerPath = "controllers\\defaultControllers\\";

        $controllerFileNames = scandir($defaultControllerPath, 1);


        foreach ($controllerFileNames as $item) {

            $fileName = "controllers\\defaultControllers\\" . $item;

            if(strpos($item,"Controller")){

                $clasFileName = substr($fileName,0,-4);

                require_once($fileName);

                $currentClass = new $clasFileName;

                $reflection = new \ReflectionClass($currentClass);
                $methods = $reflection->getMethods();


                foreach ($methods as $method) {

                    $docBlock = $method->getDocComment();
                    $pattern = "/Route\(([A-Za-z]+)\/([A-Za-z]+)\)/";

                    preg_match($pattern,$docBlock,$routeMatch);

                    if(count($routeMatch)> 0){



                        echo '<pre>'; print_r($routeMatch); echo '</pre>';

                    }

                }






            }


        }
//        echo '<pre>'; print_r($controllerFileNames[0]); echo '</pre>';






        $routeObj = [];

        $customRoutes = (object) array(
            'controller' => "Home",
            'action' => "Index",
            'customController' => 'some',
            'customAction' => 'somer'
        );

        array_push($routeObj,$customRoutes);
        $fp = fopen('config/customRoutes.json', 'w');
        fwrite($fp, json_encode($routeObj));
        fclose($fp);

    }

    private static  function loadRouteSettings(){




    }








}