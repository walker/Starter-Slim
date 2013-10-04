<?php
require '../vendor/autoload.php';
require_once dirname(dirname(__FILE__)).'/config/auto.php';

// require_once ACTION.'users.php';

// Define routes
$app->get('/', function () use ($app) {
    $app->render('index.html');
});

// Run app
$app->run();
