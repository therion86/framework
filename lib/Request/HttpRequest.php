<?php

namespace Therion86\Framework\Request;

use Therion86\Framework\Interfaces\HttpRequestInterface;

use function getallheaders;

class HttpRequest implements HttpRequestInterface
{
    private array $routeParameters = [];

    private function __construct(
        private readonly string $method,
        private readonly string $uri,
        private readonly array $headers = [],
        private readonly array $params = [],
        private readonly string $body = '',
        private readonly string $host = ''
    ) {
    }

    public static function fromGlobals(): self
    {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'get');
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $host =  $_SERVER['HTTP_HOST'];
        $headers = null;

        if (function_exists('\getallheaders')) {
            // @codeCoverageIgnoreStart
            $headers = \getallheaders();
            // @codeCoverageIgnoreEnd
        }

        if (!is_array($headers)) {
            $headers = [];
        }
        $params = array_merge($_GET, $_POST);
        $body = file_get_contents('php://input');
        return new self($method, $uri, $headers, $params, $body, $host);
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

    public function getParameter(string $parameterName): string|array|null
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

    public function getHost(): string
    {
        return $this->host;
    }
}