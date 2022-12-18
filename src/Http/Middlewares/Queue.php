<?php

namespace ArveresRoute\Http\Middlewares;

use ArveresRoute\Http\Request;
use Exception;

class Queue
{
    private static array $map = [];

    private static array $middlewareDefault = [];

    private array $middlewares = [];

    private string $controller;

    private string $method;

    private array $params;

    public function __construct(string $controller, string $method, array $params, array $middleware)
    {
        $this->controller = $controller;
        $this->middlewares = array_merge(self::$middlewareDefault, $middleware);
        $this->method = $method;
        $this->params = $params;
    }

    public static function routeMiddleware(array $map): void
    {
        self::$map = $map;
    }

    public static function middlewareDefault(array $default): void
    {
        self::$middlewareDefault = $default;
    }

    public function next(Request $request): mixed
    {
        if (empty($this->middlewares)) {
            return forward_static_call_array([new $this->controller, $this->method], $this->params);
        }

        $middleware = array_shift($this->middlewares);

        if (!isset(self::$map[$middleware])) {
            throw new Exception('Problemas ao processar o middleware ' . $middleware, 500);
        }

        $queue = $this;
        $next = function ($request) use ($queue) {
            return $queue->next($request);
        };

        return (new self::$map[$middleware])->handle($request, $next);
    }
}