<?php

namespace Framework\Interfaces;

interface HttpRequestInterface extends RequestInterface
{
    public function getRouteParameter(string $parameterName): ?string;

    public function setRouteParameters(array $routeParameters): self;
}