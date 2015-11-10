<?php
/**
 * Created by PhpStorm.
 * User: Phill
 * Date: 10/7/2015
 * Time: 8:51 PM
 */
declare(strict_types=1);

namespace controllers;


class AreaController
{

    public static function areaChecker( $controllerName){


        $classPath = "areas\\areaControllers\\".ucfirst($controllerName)."Controller.php";


        if(file_exists($classPath)){

           return true;
        }else{

            return false;
        }

    }

}