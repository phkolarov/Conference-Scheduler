<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 24.11.2015 г.
 * Time: 12:21 ч.
 */

namespace IdentitySystem\IdentityModels;


class IdentityUserModel
{

    const COL_ID = 'id';
    const COL_USERNAME = 'username';
    const COL_PASSWORD = 'password';
    const COL_FULLNAME= 'fullname';

    private $id;
    private $username;
    private $password;
    private $fullname;



    public function __construct($username, $password, $fullname,$id = null)
    {
        $this
            ->setUsername($username)
            ->setPass($password)
            ->setFullname($fullname)
            ->setId($id);
    }

    public function getId(){

        return $this->id;
    }

    public function setId($id){

        $this->id =  $id;

        return $this;

    }

    public function getUsername(){
        return $this->username;
    }

    public function setUsername($username){

        $this->username = $username;

        return $this;
    }

    public function getPassword(){
        return $this->password;
    }

    public function setPass($password){

        $this->password = $password;

        return $this;

    }
    public function getFullname(){

        return $this->fullname;
    }

    public function setFullname($fullname){

        $this->fullname = $fullname;

        return $this;
    }


}