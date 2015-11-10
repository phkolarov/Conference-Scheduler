<?php


include_once "app.php";



    $app = new app($_GET['uri']);

    $app->run();