<?php
declare(strict_types=1);
namespace HttpContext;


class HttpContext
{

    public function __construct()
    {
    }

    public static function getSession($session)
    {
        $currentSessionVariable = $_SESSION[$session];


        if (isset($currentSessionVariable)) {

            return $currentSessionVariable;
        } else {
            return null;
        }

    }


    public static function getCookie($cookie)
    {
        $currentCookieVariable = $_COOKIE[$cookie];

        if(isset($currentCookieVariable)){

            return $currentCookieVariable;
        }else{
            return null;
        }

    }

    public static function isLogged() : bool
    {
        $currentUserSession = $_COOKIE['usersession'];

        if(isset($currentUserSession)){

            return true;
        }else{
            return false;
        }

    }

}