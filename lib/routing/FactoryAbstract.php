<?php

declare(strict_types=1);

namespace framework\lib\routing;


use framework\lib\DependencyInjection;
use ReflectionClass;

abstract class FactoryAbstract
{

    protected const ROUTE_TYPE_GET = 'GET';
    protected const ROUTE_TYPE_POST = 'POST';

    protected DependencyInjection $dependencyInjection;

    public function __construct(DependencyInjection $dependencyInjection)
    {
        $this->dependencyInjection = $dependencyInjection;
    }

    protected function addRoute(string $routeUri, string $type, callable $commandCreateFunction)
    {
        $this->dependencyInjection->getRegisteredRoutes()->addRoute($routeUri, $type, $commandCreateFunction);
    }

    abstract public function registerRoutes(): void;
}