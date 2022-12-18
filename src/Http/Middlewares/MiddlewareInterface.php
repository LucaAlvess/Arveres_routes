<?php

namespace ArveresRoute\Http\Middlewares;

use ArveresRoute\Http\Request;
use Closure;

interface MiddlewareInterface
{
    public function handle(Request $request, Closure $next);
}