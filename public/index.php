<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ArveresRoute\Http\Controllers\HomeController;
$route = new \ArveresRoute\Http\Router();

$route->get('/', [HomeController::class, 'index']);
$route->post('/list', [HomeController::class, 'show']);

$route->run();

