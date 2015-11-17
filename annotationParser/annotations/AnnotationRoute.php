<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 17.11.2015 г.
 * Time: 10:51 ч.
 */

namespace annotationParser\annotations;


class AnnotationRoute
{


    public static function loadRouter($customController,$customAction)
    {

        $correctRouteSet = [];
        $str = file_get_contents('config/customRoutes.json');

        $jsonRoutes = json_decode($str);

        foreach ($jsonRoutes as $jsonRoute) {

            if($jsonRoute->CustomController == $customController && $jsonRoute->CustomAction == $customAction)
            {
                $correctRouteSet["Controller"] = $jsonRoute->Controller;
                $correctRouteSet["Action"] = $jsonRoute->Action;
            }
        }

        if(count($correctRouteSet)> 0){
            return $correctRouteSet;
        }else{

            throw new \Exception("ROute not exist in annotation or like a custom route");
        }
    }

    public static function saveCorrectDataWithReflection()
    {


        $defaultControllerPath = "controllers\\defaultControllers\\";

        $controllerFileNames = scandir($defaultControllerPath, 1);
        $settingsArrayWithAllControllersAndActions = [];
        $num = 0;
        foreach ($controllerFileNames as $item) {

            $fileName = "controllers\\defaultControllers\\" . $item;

            if (strpos($item, "Controller")) {


                $clasFileName = substr($fileName, 0, -4);

                require_once($fileName);

                $currentClass = new $clasFileName;

                $reflection = new \ReflectionClass($currentClass);
                $methods = $reflection->getMethods();


                foreach ($methods as $i => $method) {

                    $docBlock = $method->getDocComment();
                    $pattern = "/Route\(([A-Za-z]+)\/([A-Za-z]+)\)/";


                    preg_match($pattern, $docBlock, $routeMatch);

                    if (count($routeMatch) > 0) {





                        $objectToSave = (object)array(
                            "Controller" => $reflection->getName(),
                            "Action" => $method->getName(),
                            "CustomController" => $routeMatch[1],
                            "CustomAction" => $routeMatch[2]
                        );

                        $num++;
                        array_push($settingsArrayWithAllControllersAndActions, $objectToSave);


                        //echo '<pre>'; print_r($objectToSave); echo '</pre>';

                    }
                }


            }

        }

        $fp = fopen('config/customRoutes.json', 'w');
        fwrite($fp, json_encode($settingsArrayWithAllControllersAndActions));
        fclose($fp);
//        echo '<pre>';
//        print_r( json_encode($objectToSave));
//        echo '</pre>';

    }
}