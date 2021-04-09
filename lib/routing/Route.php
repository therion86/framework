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
        $routeUrl = preg_replace('#\?.*#', '', $routeUrl);
        $this->routeUrl = (string)$routeUrl;
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