<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ArveresRoute\Http\Controllers\HomeController;
$route = new \ArveresRoute\Http\Router();

$route->get('/', [HomeController::class, 'index']);
$route->get('/lists', [HomeController::class, 'list']);
$route->get('/list/{id}/user/{name}', [HomeController::class, 'show']);

$route->run();

