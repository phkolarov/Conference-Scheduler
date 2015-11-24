<html>
<head>
    <title>Conference Scheduler</title>
</head>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<body>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("Autoloader/Autoloader.php");
require('kint/Kint.class.php');
use Autoloader\Autoloader;
use IdentitySystem\IdentityUser;

Autoloader::init();


$dbName = "SoftUniProject";

\IdentitySystem\codeFirstModelBuilder\system::databaseBuilder($dbName);

Core\Database::setInstance(
    \Config\DatabaseConfig::DB_INSTANCE,
    \Config\DatabaseConfig::DB_DRIVER,
    \Config\DatabaseConfig::DB_USER,
    \Config\DatabaseConfig::DB_PASS,
    $dbName,
    \Config\DatabaseConfig::DB_HOST
);


\IdentitySystem\codeFirstModelBuilder\system::createIdentityTables();



include_once "app.php";

$app = new app($_GET['uri']);

$app->run(); ?>

</body>
</html>