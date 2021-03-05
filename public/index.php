<?php

// import autoload
require_once __DIR__ . "/../vendor/autoload.php";



// imports
use app\core\Application;

// create application
$app = new Application(dirname(__DIR__));

// define routes
$app->router->get('/', function() {
    return 'Hello man bro';
});

$app->router->get('/contact', 'contact');
$app->router->get('/', 'home');

// execute app
$app->run();