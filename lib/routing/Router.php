<?php

declare(strict_types=1);

namespace framework\lib\routing;


use framework\lib\DependencyInjection;
use framework\lib\request\Request;
use JetBrains\PhpStorm\Pure;

class Router
{
    private RouteContainer $routes;
    private Request $request;

    #[Pure] public function __construct(DependencyInjection $di)
    {
        $this->routes = $di->getRegisteredRoutes();
        $this->request = $di->getRequest();
    }

    /**
     * @throws RouteNotFoundException
     */
    public function printContent(): string
    {
        $routes = $this->routes;
        $uri = preg_replace('#\?.*#', '', $this->request->getUri());
        $requestMethod = $this->request->getMethod();
        if (!$routes->match($uri, $requestMethod)) {
            throw new RouteNotFoundException('Route ' . $uri . ' with type ' . $requestMethod . ' is not defined!');
        }
        $route = $routes->getRoute($uri, $requestMethod);

        $command = $route->callable();
        $response = $command->execute();

        foreach ($response->getHeaders() as $header) {
            header($header, false);
        }
        http_response_code($response->getStatusCode());

        return $response->getBody();
    }

}