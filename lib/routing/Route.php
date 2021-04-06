<?php

declare(strict_types=1);

namespace framework\lib\routing;

class Route
{
    private string $routeUrl;
    private string $type;
    private $commandCreateFunction;

    public function __construct(string $routeUrl, string $type, callable $commandCreateFunction)
    {
        $this->routeUrl = $routeUrl;
        $this->type = $type;
        $this->commandCreateFunction = $commandCreateFunction;
    }

    public function getRouteUri(): string
    {
        return $this->routeUrl;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function callable()
    {
        return ($this->commandCreateFunction)();
    }
}