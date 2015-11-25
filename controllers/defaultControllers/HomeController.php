<?php


namespace controllers\defaultControllers;
use views\View;


class HomeController
{


       public function Index()
    {

            $user = new \IdentitySystem\IdentityUser();


            $session = new \IdentitySystem\IdentityRepository\IdentitySessionRepository();

               $sessions=  $session->findAll();

            //d($session->filterById(1)->delete());


            $registeredUserInfo = $user->UserLogin('admin','admin');



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