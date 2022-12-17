<?php

namespace ArveresRoute\Http;

class Request
{
    private string $uri;

    private string $httpMethod;

    private array $headers;

    public function __construct()
    {
        $this->uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $this->httpMethod = $_SERVER['REQUEST_METHOD'];
        $this->headers = getallheaders();
    }

    public function getUri(): string
    {
        return rtrim(strtolower($this->uri), '/');
    }

    public function getHttpMethod(): string
    {
        return $this->httpMethod;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function inputPost(string $field)
    {
        return $_POST[$field] ?? throw new \Exception("field {$field} does not exist");
    }

    public function allPost(): array
    {
        return $_POST;
    }

    public function PostVarsOnly(string|array $fields): array|string
    {
        if (is_string($fields)) {
            return self::inputPost($fields);
        }

        $postVars = self::allPost();
        $only = [];
        foreach ($fields as $field) {
            if (isset($postVars[$field])) {
                $only[$field] = $postVars[$field];
            }
        }

        return $only;
    }

    public function exceptPost(string|array $fields): array
    {
        $postVars = self::allQueryParams();

        if (is_array($fields)) {
            foreach ($fields as $field) {
                unset($postVars[$field]);
            }
        }

        if (is_string($fields)) {
            unset($postVars[$fields]);
        }

        return $postVars;
    }

    public function allQueryParams(): array
    {
        return $_GET;
    }

    public function inputGet($field)
    {
        return $_GET[$field] ?? throw new \Exception("field {$field} does not exist");
    }

    public function queryParamsOnly(string|array $fields): array|string
    {
        if (is_string($fields)) {
            return self::inputGet($fields);
        }

        $postVars = self::allQueryParams();
        $only = [];
        foreach ($fields as $field) {
            if (isset($postVars[$field])) {
                $only[$field] = $postVars[$field];
            }
        }

        return $only;
    }

    public function exceptQueryParams(string|array $fields): array
    {
        $queryParams = self::allQueryParams();

        if (is_array($fields)) {
            foreach ($fields as $field) {
                unset($queryParams[$field]);
            }
        }

        if (is_string($fields)) {
            unset($queryParams[$fields]);
        }

        return $queryParams;
    }
}