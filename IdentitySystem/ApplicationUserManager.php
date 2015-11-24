<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 24.11.2015 г.
 * Time: 14:08 ч.
 */

namespace IdentitySystem;


class ApplicationUserManager
{
    private $userAccount = '';

    function __construct(iUser $user)
    {
        $this->userAccount = new $user();
    }

   function returnUser(){

       return $this->userAccount;
    }

    function checkForExtendMethods()
    {
        $reflectionClass = new \ReflectionClass(new IdentityUser());
    }

    function getUser(): iUser{

        return $this->userAccount;
    }

}