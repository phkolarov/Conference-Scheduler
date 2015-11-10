<?php
/**
 * Created by PhpStorm.
 * User: Phill
 * Date: 10/7/2015
 * Time: 7:04 PM
 */
declare(strict_types=1);

namespace controllers;


class DefaultRouterController
{


    /**
     * @test
     */
    public function index(){


        var_dump($this::$controller);
    }
}