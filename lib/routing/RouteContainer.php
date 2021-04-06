<?php

declare(strict_types=1);

namespace framework\lib\routing;


class RouteContainer
{
    private array $routes = [];

    public function addRoute(string $routeUrl, string $type, callable $commandCreateFunction): void
    {
        $route = new Route($routeUrl, $type, $commandCreateFunction);
        if (array_key_exists($route->getRouteUri(), $this->routes)
            && array_key_exists($route->getType(), $this->routes[$route->getRouteUri()])
        ) {
            throw new RouteAlreadyExistsException(
                'The route ' . $route->getRouteUri() . ' with type ' . $route->getType() . ' is already defined!'
            );
        }
        $this->routes[$route->getRouteUri()][$route->getType()] = $route;
    }

    public function match(string $routeUri, string $type): bool
    {
        return array_key_exists($routeUri, $this->routes) && array_key_exists($type, $this->routes[$routeUri]);
    }

    public function getRoute(string $routeUri, string $type): Route
    {
        return $this->routes[$routeUri][$type];
    }
}