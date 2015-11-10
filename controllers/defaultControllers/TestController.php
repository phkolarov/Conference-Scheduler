<?php

declare(strict_types=1);

namespace controllers\defaultControllers;


class TestController
{



    public function __construct(){

        var_dump('tes1t');
    }


//    /**
//     * @Route("nest/nester")
//     */
    public function nest(){

        var_dump('nester');
    }
}