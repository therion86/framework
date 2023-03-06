<?php

declare(strict_types=1);

namespace Framework\Routing;

use Framework\DependencyInjection\DependencyInjection;
use Framework\Exceptions\ClassNotRegisteredException;
use Framework\Exceptions\HandlerNotFoundException;
use Framework\Interfaces\ConstructorParameterTypeNotFoundException;
use Framework\Interfaces\HandlerInterface;
use Framework\Exceptions\HandlerInterfaceNotFullfilledException;
use Framework\Interfaces\ResponseInterface;
use Framework\Interfaces\RouteNotFoundException;
use ReflectionException;

class Router
{
    private const GET = 'GET';
    private const POST = 'POST';
    private const PUT = 'PUT';
    private const DELETE = 'DELETE';


    private string $requestUri;
    private string $requestPath;
    private string $basePath;
    /**
     * @var array<Route>
     */
    private array $routes;

    public function __construct(private DependencyInjection $di)
    {
        $this->requestUri = $_SERVER['REQUEST_URI'];
        $this->basePath = str_replace('/cli.php', '', $_SERVER['SCRIPT_NAME']);
        $requestPath = str_replace($this->basePath, '', $this->requestUri);
        $this->requestPath = strtok($requestPath, '?');
    }

    /**
     * @return ResponseInterface
     * @throws HandlerInterfaceNotFullfilledException
     * @throws HandlerNotFoundException
     * @throws RouteNotFoundException
     * @throws ReflectionException
     * @throws ClassNotRegisteredException
     * @throws ConstructorParameterTypeNotFoundException
     */
    public function route(): ResponseInterface
    {
        if (!isset($this->routes[$this->requestPath])) {
            throw new RouteNotFoundException('Route for uri ' . $this->requestUri . ' not found!');
        }
        $route = $this->routes[$this->requestPath];
        $handler = $route->getHandler();
        if (!class_exists($handler)) {
            throw new HandlerNotFoundException('Handler ' . $handler . ' not found on the filesystem!');
        }
        $handler = $this->di->getContainer()->load($handler);
        if (!$handler instanceof HandlerInterface) {
            throw new HandlerInterfaceNotFullfilledException('Handler must implement HandlerInterface!');
        }
        return $handler->execute($this->di->getRequest(), $this->di->generateResponse());
    }

    private function registerRoute(Route $route): void
    {
        $this->routes[$route->getUri()] = $route;
    }

    public function registerGetRoute(string $routeName, string $routeUri, string $handler, array $parameters): self
    {
        $route = new Route($routeUri, $routeName, self::GET, $parameters, $handler);
        $this->registerRoute($route);
        return $this;
    }

    public function registerPostRoute(string $routeName, string $routeUri, string $handler, array $parameters): self
    {
        $route = new Route($routeUri, $routeName, self::POST, $parameters, $handler);
        $this->registerRoute($route);
        return $this;
    }

    public function registerPutRoute(string $routeName, string $routeUri, string $handler, array $parameters): self
    {
        $route = new Route($routeUri, $routeName, self::PUT, $parameters, $handler);
        $this->registerRoute($route);
        return $this;
    }

    public function registerDeleteRoute(string $routeName, string $routeUri, string $handler, array $parameters): self
    {
        $route = new Route($routeUri, $routeName, self::DELETE, $parameters, $handler);
        $this->registerRoute($route);
        return $this;
    }
}