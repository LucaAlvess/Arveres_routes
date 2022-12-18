<?php

namespace ArveresRoute\Http\Middlewares;

use ArveresRoute\Http\Request;
use Closure;

class trimString implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        $_GET = array_map('trim', $_GET);
        $_POST = array_map('trim', $_POST)   ;

        return $next($request);
    }
}