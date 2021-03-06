<?php

// import autoload
require_once __DIR__ . "/../vendor/autoload.php";



// imports
use app\core\Application;
use app\controllers\ContactController;
use app\controllers\AuthController;

// create application
$app = new Application(dirname(__DIR__));

// define routes
$app->router->get('/', [ContactController::class, 'home']);

$app->router->get('/contact', [ContactController::class, 'contact']);
$app->router->post('/contact', [ContactController::class, 'handleContact']);

$app->router->get('/login', [AuthController::class, 'login']);
$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->post('/register', [AuthController::class, 'register']);

// execute app
$app->run();