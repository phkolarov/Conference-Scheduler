<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 24.11.2015 г.
 * Time: 12:06 ч.
 */

namespace IdentitySystem;


class IdentityUser implements iUser
{


    function __construct()
    {

    }


    function BuildIdentityDataBase()
    {

    }

    function UserRegistration($username,$password,$fullname)
    {

    }

    function UserLogin($username,$passowrd)
    {

    }

    function UserLogout()
    {

    }

    function checkForExtendMethods()
    {
        $reflectionClass = new \ReflectionClass(new IdentityUser());
    }



}