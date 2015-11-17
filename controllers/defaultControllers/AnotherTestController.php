<?php
/**
 * Created by PhpStorm.
 * User: Filip
 * Date: 17.11.2015 г.
 * Time: 14:45 ч.
 */

namespace controllers\defaultControllers;


class AnotherTestController
{


    /**
     * @Route(AnotherTEstCOntrollr/customAnotherAction)
     */
    public function Index()
    {

        var_dump('AnotherTest');
        return  View::make();

    }
}