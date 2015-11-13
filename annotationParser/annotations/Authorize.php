<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 13.11.2015 г.
 * Time: 10:09 ч.
 */
namespace annotationParser\annotations;

class Authorize
{


    public static function checkForAuthorize(){

        $defaultParameters = [
            "controller" => "Home",
            "action" => "Index"

        ];

        if(!isset($_COOKIE["session"])){
            return $defaultParameters;
        }
    }











}