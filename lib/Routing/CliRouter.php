<?php

declare(strict_types=1);


namespace Therion86\Framework\Routing;

use Exception;
use Therion86\Framework\Cli\Argument;
use Therion86\Framework\DependencyInjection\CliDependencyInjection;
use Therion86\Framework\Exceptions\HandlerInterfaceNotFullfilledException;
use Therion86\Framework\Exceptions\HandlerNotFoundException;
use Therion86\Framework\Exceptions\RouteAlreadyExistsException;
use Therion86\Framework\Exceptions\RouteNotFoundException;
use Therion86\Framework\Interfaces\CliHandlerInterface;

class CliRouter
{
    /**
     * @var Route[]
     */
    private array $routes = [];

    public function __construct(private CliDependencyInjection $di, private Argument $methodParams)
    {
    }

    public function route(): void
    {

        if (false === $this->methodParams->getMethod()) {
            throw new Exception('Mandatory function name was not set');
        }

        if (!isset($this->routes[$this->methodParams->getMethod()])) {
            throw new RouteNotFoundException('Method ' . $this->methodParams->getMethod() . ' not found');
        }
        $route = $this->routes[$this->methodParams->getMethod()];
        $handler = $route->getHandler();
        if (!class_exists($handler)) {
            throw new HandlerNotFoundException('Handler ' . $handler . ' not found on the filesystem!');
        }

        $handler = $this->di->getContainer()->load($handler);
        if (!$handler instanceof CliHandlerInterface) {
            throw new HandlerInterfaceNotFullfilledException('Handler must implement CliModuleFactoryInterface!');
        }

        foreach ($route->getParameters() as $parameterName => $parameterDescription) {
            if (! $this->methodParams->hasArg($parameterName)) {
                throw new Exception('Parameter ' . $parameterName . ' is mandatory but not set!');
            }
            if (! preg_match("#$parameterDescription#", $this->methodParams->getArgValue($parameterName))) {
                throw new Exception('Mandatory value of parameter (' . $parameterName . ') does not match to the expression!');
            }
        }

        $handler->execute($this->methodParams);
    }

    /**
     * @throws RouteAlreadyExistsException
     */
    public function registerCommand(string $commandName, string $handler, array $parameters)
    {
        $this->registerRoute(new Route($commandName, 'cli', $parameters, $handler));
    }

    private function registerRoute(Route $route): void
    {
        if (isset($this->routes[$route->getUri()])) {
            throw new RouteAlreadyExistsException(
                sprintf('Route % for method %s already exists!', $route->getUri(), $route->getMethod())
            );
        }
        $this->routes[$route->getUri()] = $route;
    }
}