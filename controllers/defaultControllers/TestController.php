<?php

namespace controllers\defaultControllers;
use views\View;

class TestController
{


    /**
     * @Route(customTestHome/customTestAction)
     */
    public function Index()
    {

        var_dump('TestIndexController');
        return  View::make();

    }


    /**
     * @Route(customTestContact/customTestAction)
     * @GET
     */
    public function Contact(){
        var_dump("TestContactController");

        return  View::make();

    }



}