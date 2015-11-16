<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 13.11.2015 г.
 * Time: 10:09 ч.
 */

namespace annotationParser\annotations;


class Admin
{


    public static function checkAdminRole()
    {

        if(!isset($_COOKIE["role"])){



            header("Location: Home/Index");
            die();
        }

        if($_COOKIE["role"] != "admin"){

            header("Location: Home/Index");
            die();
        }
    }
}