<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 13.11.2015 г.
 * Time: 10:11 ч.
 */

namespace annotationParser\annotations;


class CRUD
{

    public static $crudArrayString = ["PUT", "POST", "DELETE", "UPDATE", "GET"];

    public static function CRUDChecker( string $annotation){

        $method = $_SERVER['REQUEST_METHOD'];

        if( in_array($annotation,self::$crudArrayString)){

            if($annotation != $method){

                echo $annotation;
                throw new \Exception("Invalid Request");
            }
        }

    }

}