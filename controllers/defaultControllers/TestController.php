<?php

namespace controllers\defaultControllers;
use views\View;

class TestController
{

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