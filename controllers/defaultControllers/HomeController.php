<?php


namespace controllers\defaultControllers;
use views\View;

class HomeController
{


    public function Index()
    {

        return View::make();

        var_dump('IndexController');
    }


    public function Contact(){


        var_dump("ContactController");
    }

}