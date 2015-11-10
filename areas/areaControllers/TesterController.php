<?php

declare(strict_types=1);

namespace areas\areaControllers;

class TesterController
{


    public function __construct(){

        var_dump("TestController");
    }


    /**
     * @Route("PEESHT/ROUTE")
     */
    public function Pei(){

        var_dump('peem!');

    }
}