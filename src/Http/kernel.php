<?php

use ArveresRoute\Http\Middlewares\Queue;

Queue::routeMiddleware([
    'maintenance' => \ArveresRoute\Http\Middlewares\Maintenance::class,
    'stringTrim' => \ArveresRoute\Http\Middlewares\trimString::class
]);

Queue::middlewareDefault([
    'maintenance',
    'stringTrim'
]);