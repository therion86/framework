<?php

namespace Framework\Request;

use Framework\Interfaces\RequestInterface;

class HttpRequest implements RequestInterface
{
    public function __construct(
        private string $method,
        private string $uri,
        private array $headers = [],
        private array $params = [],
        private array $routeParameters = []
    ) {
    }

    public static function fromGlobals(array $routeParameters): self
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'get');
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $headers = getallheaders() ?? [];
        $params = array_merge($_GET, $_POST);
        return new self($method, $uri, $headers, $params, $routeParameters);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getParameter(string $parameterName): ?string
    {
        return $this->params[$parameterName] ?? null;
    }

    public function getRouteParameter(string $parameterName): ?string
    {
        return $this->routeParameters[$parameterName] ?? null;
    }

    public function getParameters(): array
    {
        return $this->params;
    }
}