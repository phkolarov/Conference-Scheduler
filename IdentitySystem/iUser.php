<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 24.11.2015 г.
 * Time: 14:41 ч.
 */

namespace IdentitySystem;


interface iUser
{

    public function userLogin($username,$password);

    public function userLogout();

    public function userRegistration($username,$password,$fullname);

}