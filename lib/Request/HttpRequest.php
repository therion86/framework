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
        private array $routeParameters = [],
        private string $body = ''
    ) {
    }

    public static function fromGlobals(array $routeParameters): self
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'get');
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $headers = getallheaders() ?? [];
        $params = array_merge($_GET, $_POST);
        $body = file_get_contents('php://input');
        return new self($method, $uri, $headers, $params, $routeParameters, $body);
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

    public function getBody(): string
    {
        return $this->body;
    }
}