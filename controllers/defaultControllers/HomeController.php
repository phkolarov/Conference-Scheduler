<?php


namespace controllers\defaultControllers;
use views\View;
use IdentitySystem\IdentityRepository\IdentitUserRepository;

class HomeController
{


       public function Index()
    {
        $user = new IdentitUserRepository();
        $user = $user->findOne();

        d($user);

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