<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 25.11.2015 г.
 * Time: 14:58 ч.
 */

namespace IdentitySystem\IdentityModels;
use DateTime;

class IdentitySessionModel
{
    const COL_ID = 'id';
    const COL_USERID = 'userId';
    const COL_SESSION = 'session';
    const COL_LOGINDATE= 'logindate';

    private $id;
    private $userId;
    private $session;
    private $logindate;



    public function __construct($userId, $session, $id = null)
    {
        $this
            ->setUserId($userId)
            ->setSession($session)
            ->setLoginDate()
            ->setId($id);
    }

    public function getId(){

        return $this->id;
    }

    public function setId($id){

        $this->id =  $id;

        return $this;

    }

    public function getUserId(){
        return $this->userId;
    }

    public function setUserId($userId){

        $this->userId = $userId;

        return $this;
    }

    public function getSession(){
        return $this->session;
    }

    public function setSession($session){

        $this->session = $session;

        return $this;

    }
    public function getLoginDate(){

        return $this->logindate;
    }

    public function setLoginDate(){

        $date = date("Y-m-d H:i:s");
        $this->logindate = $date ;

        return $this;
    }

}