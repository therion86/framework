<?php

declare(strict_types=1);

namespace Therion86\Framework\Routing;

readonly class Route
{
    public function __construct(
        public string $uri,
        public RouteType $method,
        public array $parameters,
        public string $handler
    ) {
    }
}