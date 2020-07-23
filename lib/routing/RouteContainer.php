<?php

declare(strict_types=1);

namespace framework\routing;

use framework\exceptions\RouteException;
use framework\interfaces\RouteDtoInterface;

/**
 * @author Therion86
 */
class RouteContainer
{

    /**
     * @var RouteDto[]
     */
    private array $routes;

    /**
     * @author Therion86
     */
    public function __construct()
    {
        $this->routes = [];
    }

    /**
     * @param string $type
     * @param string $routeMap
     * @param string $factoryClassName
     * @param string $pageClassName
     * @return void
     * @throws RouteException
     * @author Therion86
     */
    private function addRoute(string $type, string $routeMap, string $factoryClassName, string $pageClassName): void
    {
        $routeName = str_replace('/', '.', $routeMap) . $type;
        if (array_key_exists($routeName, $this->routes)) {
            throw RouteException::forAlreadyExists($routeName);
        }
        $this->routes[$routeName] = new RouteDto($type, $routeName, $routeMap, $factoryClassName, $pageClassName);
    }

    /**
     * @param string $routeMap
     * @param string $factoryClassName
     * @param string $pageClassName
     * @return void
     * @throws RouteException
     * @author Therion86
     */
    public function addGet(
        string $routeMap,
        string $factoryClassName,
        string $pageClassName
    ): void {
        $this->addRoute(
            Routing::GET,
            $routeMap,
            $factoryClassName,
            $pageClassName
        );
    }

    /**
     * @param string $routeMap
     * @param string $pageClassName
     * @param string $factoryClassName
     * @return void
     * @throws RouteException
     * @author Therion86
     */
    public function addPost(
        string $routeMap,
        string $factoryClassName,
        string $pageClassName
    ): void {
        $this->addRoute(
            Routing::POST,
            $routeMap,
            $factoryClassName,
            $pageClassName
        );
    }

    /**
     * @return RouteDtoInterface[]
     * @author Therion86
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}