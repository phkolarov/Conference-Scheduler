<?php

namespace controllers\defaultControllers;
use views\View;

class TestController
{


    /**
     * @Route(customController/customAction)
     * @Authorize
     * @Admin
     * @POST
     */
    public function Index()
    {

        var_dump('TestIndexController');
        return  View::make();

    }



    public function Contact(){
        var_dump("TestContactController");

        return  View::make();

    }



}