<?php

namespace ArveresRoute\Http;

use Exception;

class Router
{
    private string $standardVariable = '/{(.*?)}/';

    private array $routes;

    private Request $request;

    public function __construct()
    {
        $this->request = new Request();
    }

    public function get(string $uri, array $action): self
    {
        $this->addRoute('GET', $uri, $action);

        return $this;
    }

    public function post(string $uri, array $action): self
    {
        $this->addRoute('POST', $uri, $action);

        return $this;
    }

    public function run(): mixed
    {
        $currentRoute = $this->getActionCurrentRoute();

        $controller = new $currentRoute['controller'];
        $method = $currentRoute['method'];
        $params = $currentRoute['params'];

        return forward_static_call_array([$controller, $method], $params);
    }

    private function addRoute(string $httpMethod, string $uri, array $action): void
    {
        [$controller, $method] = $action;
        $uri = rtrim($uri, '/');

        if ($params = $this->addRouteParams($uri)) {
            $uri = preg_replace($this->standardVariable, '([a-z0-9]+)', $uri);
        }

        $uri = '/^' . str_replace('/', '\/', $uri) . '$/';

        $this->routes[$uri][$httpMethod] = [
            'controller' => $controller,
            'method' => $method,
            'params' => $params ?? []
        ];
    }

    private function addRouteParams(string $uri): array
    {
        if (preg_match_all($this->standardVariable, $uri, $matches)) {
            unset($matches[0]);
            return $matches[1];
        }

        return [];
    }

    private function getActionCurrentRoute(): array
    {
        $uri = $this->request->getUri();
        $httpMethod = $this->request->getHttpMethod();

        foreach ($this->routes as $route => $methodRoute) {
            if (preg_match($route, $uri, $matches)) {
                return $this->routeExist($methodRoute, $httpMethod, $matches);
            }
        }

        throw new Exception('Página não encontrada');
    }

    private function routeExist($methodRoute, $httpMethod, $matches): array
    {
        if (isset($methodRoute[$httpMethod])) {
            return $this->addValuesRouteParams($methodRoute, $httpMethod, $matches);
        }

        throw new Exception('Método não compatível');
    }

    private function addValuesRouteParams($methodRoute, $httpMethod, $matches): array
    {
        unset($matches[0]);

        $methodRoute[$httpMethod]['params'] = array_combine(
            $methodRoute[$httpMethod]['params'],
            $matches
        );
        $methodRoute[$httpMethod]['params']['request'] = $this->request;

        return $methodRoute[$httpMethod];
    }
}