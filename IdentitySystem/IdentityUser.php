<?php
declare(strict_types=1);
namespace IdentitySystem;


class IdentityUser // implements iUser
{


    function __construct()
    {
    }


    function BuildIdentityDataBase()
    {

    }

    function UserRegistration($username,$password,$fullname) : array
    {

        $upvalidate = self::userNamePasswordValidator($username,$password);
        $arrayResult = [];

        if($upvalidate != "correct"){

            $arrayResult['error'] = $upvalidate;
        }

        $password = md5($password);

        $userRepo = new \IdentitySystem\IdentityRepository\IdentityUserRepository();


        $fitelredUser = $userRepo->filterByUsername($username)->findOne();



        if($fitelredUser->getId() != null){

            $arrayResult['error'] = "Existed user!";

        }

        $userRepo->add($newUser = new \IdentitySystem\IdentityModels\IdentityUserModel(
            $username,$password,$fullname
        ));

        $userRepo->save();
        $arrayResult['user'] = $fitelredUser;

        return $arrayResult;
    }

    function UserLogin($username,$passowrd) : array
    {
        $salt = "SALTFORSESSION";
        $generatedSession = md5($salt);
        $loginPassword = md5($passowrd);

        $arrayResult = [];

        $userRepo = new \IdentitySystem\IdentityRepository\IdentityUserRepository();

        $registeredUser = $userRepo->filterByUsername($username)->findOne();

        if($registeredUser->getPassword() == $loginPassword){


            $arrayResult["user"] = $registeredUser;
            $arrayResult['session'] = $loginPassword;

            $generateSessionRow = new \IdentitySystem\IdentityRepository\IdentitySessionRepository();


            $session = new \IdentitySystem\IdentityModels\IdentitySessionModel( $registeredUser->getId(),$generatedSession);


            $generateSessionRow->add($session);
            $generateSessionRow->save();



        }else{

            $arrayResult["error"] = 'Invalid username or password';
        }


        return $arrayResult;
    }

    function UserLogout($username)
    {
        $arrayResult = [];

        $userRepo = new \IdentitySystem\IdentityRepository\IdentityUserRepository();
        $sessionRepo = new\IdentitySystem\IdentityRepository\IdentitySessionRepository();

        $registeredUser = $userRepo->filterByUsername($username)->findOne();
        d($registeredUser);

        $userSessions = $sessionRepo->filterByUserId($registeredUser->getId())->delete();

        d($userSessions);

    }

    function checkForExtendMethods()
    {
        $reflectionClass = new \ReflectionClass(new IdentityUser());
    }


    function setSession($username){

        $arrayResult = [];

        $userRepo = new \IdentitySystem\IdentityRepository\IdentityUserRepository();

        $registeredUser = $userRepo->filterByUsername($username)->findOne();



    }

    function userNamePasswordValidator($username,$password) : string{

        $usernamelenth = 3;
        $passwordLenth = 3;
        if(strlen($username) < $usernamelenth){

            return "Username length is less than $usernamelenth";
        }else if(strlen($password) < $passwordLenth){

            return "Password length is less than $passwordLenth";
        }

        return "correct";
    }


}