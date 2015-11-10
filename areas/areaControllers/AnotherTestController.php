<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 8.10.2015 ã.
 * Time: 10:23 ÷.
 */
declare(strict_types=1);

namespace areas\areaControllers;


class AnotherTestController
{

    public function __construct(){

        var_dump("AnotherTestController");
    }


    /**
     * @Route("MILKA/MILKA")
     */
    public function Milka(){


        var_dump('milka');
    }
}