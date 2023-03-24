<?php

declare(strict_types=1);

namespace Framework\Routing;

class Route
{
    public function __construct(
        private string $uri,
        private string $method,
        private array $parameters,
        private string $handler
    ) {
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }
}