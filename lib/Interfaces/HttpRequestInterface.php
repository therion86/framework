<?php

namespace Therion86\Framework\Interfaces;

/**
 * @codeCoverageIgnore
 */
interface HttpRequestInterface extends RequestInterface
{
    public function getRouteParameter(string $parameterName): ?string;

    public function setRouteParameters(array $routeParameters): self;
}