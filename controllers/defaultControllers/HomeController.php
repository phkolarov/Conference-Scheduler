<?php


namespace controllers\defaultControllers;
use views\View;


class HomeController
{


    /**
     * @Admin
     * @elena
     * @Route(customController/customAction)
     * @Authorize
     * @Admin
     * @GET
     */
    public function Index()
    {

        return View::make();

        var_dump('IndexController');
    }

    /**
     * @Authorize
     * @GET
     */
    public function Contact(){


        var_dump("ContactController");
    }

}