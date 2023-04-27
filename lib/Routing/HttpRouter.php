<?php

declare(strict_types=1);

namespace Therion86\Framework\Routing;

use Therion86\Framework\DependencyInjection\HttpDependencyInjection;
use Therion86\Framework\Exceptions\ClassNotRegisteredException;
use Therion86\Framework\Exceptions\ConstructorParameterTypeNotFoundException;
use Therion86\Framework\Exceptions\HandlerInterfaceNotFullfilledException;
use Therion86\Framework\Exceptions\HandlerNotFoundException;
use Therion86\Framework\Exceptions\RouteAlreadyExistsException;
use Therion86\Framework\Exceptions\RouteNotFoundException;
use Therion86\Framework\Interfaces\HandlerInterface;
use Therion86\Framework\Interfaces\ResponseInterface;
use ReflectionException;

class HttpRouter
{
    private const GET = 'GET';
    private const POST = 'POST';
    private const PUT = 'PUT';
    private const DELETE = 'DELETE';
    private const PATCH = 'PATCH';

    private string $requestUri;
    private string $requestPath;
    private string $basePath;
    /**
     * @var array<array<Route>>
     */
    private array $routes;

    private string $requestType;

    public function __construct(private HttpDependencyInjection $di)
    {
        $this->requestUri = $_SERVER['REQUEST_URI'];
        $this->basePath = str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']);
        $requestPath = str_replace($this->basePath, '', $this->requestUri);
        $this->requestPath = strtok($requestPath, '?');
        $this->requestType = strtoupper($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @return ResponseInterface
     * @throws HandlerInterfaceNotFullfilledException
     * @throws HandlerNotFoundException
     * @throws RouteNotFoundException
     * @throws ReflectionException
     * @throws ClassNotRegisteredException
     * @throws ConstructorParameterTypeNotFoundException
     * @throws \Exception
     */
    public function route(): ResponseInterface
    {
        if (!isset($this->routes[$this->requestType])) {
            throw new RouteNotFoundException('Route for uri ' . $this->requestUri . ' not found!');
        }
        $route = null;
        $routeParameters = [];
        foreach ($this->routes[$this->requestType] as $route) {
            $parameterNames = array_keys($route->getParameters());
            $parameterValues = array_values($route->getParameters());
            $routeUri = preg_replace(
                array_map(fn($name) => '#{(' . $name . ')}#', $parameterNames),
                array_map(fn($name) => '(?<$1>' . $name . ')', $parameterValues),
                $route->getUri()
            );
            if (!preg_match('#^' . str_replace('/', '\\/', $routeUri) . '$#', $this->requestPath, $routeParameters)) {
                $route = null;
                continue;
            }
            break;
        }
        if (null === $route) {
            throw new RouteNotFoundException('Route for uri ' . $this->requestUri . ' not found!');
        }
        $handler = $route->getHandler();
        if (!class_exists($handler)) {
            throw new HandlerNotFoundException('Handler ' . $handler . ' not found on the filesystem!');
        }
        $handler = $this->di->getContainer()->load($handler);
        if (!$handler instanceof HandlerInterface) {
            throw new HandlerInterfaceNotFullfilledException('Handler must implement HandlerInterface!');
        }

        return $handler->execute(
            $this->di->getRequest()->setRouteParameters($routeParameters),
            $this->di->generateResponse()
        );
    }

    private function registerRoute(Route $route): void
    {
        if (isset($this->routes[$route->getMethod()][$route->getUri()])) {
            throw new RouteAlreadyExistsException(
                sprintf('Route % for method %s already exists!', $route->getUri(), $route->getMethod())
            );
        }
        $this->routes[$route->getMethod()][$route->getUri()] = $route;
    }

    public function registerGetRoute(string $routeUri, string $handler, array $parameters): self
    {
        $route = new Route($routeUri, self::GET, $parameters, $handler);
        $this->registerRoute($route);
        return $this;
    }

    public function registerPostRoute(string $routeUri, string $handler, array $parameters): self
    {
        $route = new Route($routeUri, self::POST, $parameters, $handler);
        $this->registerRoute($route);
        return $this;
    }

    public function registerPutRoute(string $routeUri, string $handler, array $parameters): self
    {
        $route = new Route($routeUri, self::PUT, $parameters, $handler);
        $this->registerRoute($route);
        return $this;
    }

    public function registerPatchRoute(string $routeUri, string $handler, array $parameters): self
    {
        $route = new Route($routeUri, self::PATCH, $parameters, $handler);
        $this->registerRoute($route);
        return $this;
    }

    public function registerDeleteRoute(string $routeUri, string $handler, array $parameters): self
    {
        $route = new Route($routeUri, self::DELETE, $parameters, $handler);
        $this->registerRoute($route);
        return $this;
    }
}
