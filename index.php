<html>
<head>
    <title>Conference Scheduler</title>
</head>

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<body>

<?php

include_once "app.php";

$app = new app($_GET['uri']);

$app->run(); ?>

</body>
</html>