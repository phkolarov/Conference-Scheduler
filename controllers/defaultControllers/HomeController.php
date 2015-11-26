<?php


namespace controllers\defaultControllers;
use views\View;


class HomeController
{


       public function Index()
    {

            $user = new \IdentitySystem\IdentityUser();


            $session = new \IdentitySystem\IdentityRepository\IdentitySessionRepository();

               $sessions =  $session->findAll();



            $registeredUserInfo = $user->UserLogin('admin','admin');
//            $user->UserLogout('admin');


        return View::make();

    }

    /**
     * @Route(customHome/customHomeAction)
     * @Authorize
     * @GET
     */
    public function Contact(){


        var_dump("ContactController");
    }

}