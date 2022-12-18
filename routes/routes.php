<?php

use ArveresRoute\Http\Controllers\HomeController;

try {

    $route = new \ArveresRoute\Http\Router();

    $route->get('/', [HomeController::class, 'index']);

    $route->run();

} catch (Exception $exception) {
    echo $exception->getMessage();
}