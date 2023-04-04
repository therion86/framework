<?php

namespace Framework\Request;

use Framework\Interfaces\HttpRequestInterface;

class HttpRequest implements HttpRequestInterface
{
    private array $routeParameters = [];

    public function __construct(
        private string $method,
        private string $uri,
        private array $headers = [],
        private array $params = [],
        private string $body = ''
    ) {
    }

    public static function fromGlobals(): self
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'get');
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $headers = getallheaders() ?? [];
        $params = array_merge($_GET, $_POST);
        $body = file_get_contents('php://input');
        return new self($method, $uri, $headers, $params, $body);
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

    public function getParameters(): array
    {
        return $this->params;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getRouteParameter(string $parameterName): ?string
    {
        return $this->routeParameters[$parameterName] ?? null;
    }

    public function setRouteParameters(array $routeParameters): self
    {
        $this->routeParameters = $routeParameters;
        return $this;
    }
}