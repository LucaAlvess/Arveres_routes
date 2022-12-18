<?php

namespace ArveresRoute\Http\Middlewares;

use ArveresRoute\Http\Request;
use Closure;

class Maintenance implements MiddlewareInterface
{
    public function handle(Request $request, Closure $next)
    {
        if (false) {
            throw new \Exception('A aplicação está em manutenção. Por favor, tente mais tarde', 200);
        }

        return $next($request);
    }
}