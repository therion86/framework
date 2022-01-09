<?php

declare(strict_types=1);

namespace framework\lib\modules;

use framework\lib\DependencyInjection;
use framework\lib\plugins\PluginContainer;
use ReflectionClass;

abstract class FactoryAbstract implements ModuleFactoryInterface
{
    protected DependencyInjection $dependencyInjection;

    public function __construct(DependencyInjection $dependencyInjection)
    {
        $this->dependencyInjection = $dependencyInjection;
    }

    private function addRoute(string $routeUri, string $type, callable $commandCreateFunction): void
    {
        $this->dependencyInjection->getRegisteredRoutes()->addRoute($routeUri, $type, $commandCreateFunction);
    }

    protected function addGetRoute(string $routeUri, callable $commandCreateFunction): void
    {
        $this->addRoute($routeUri, 'GET', $commandCreateFunction);
    }

    protected function addPostRoute(string $routeUri, callable $commandCreateFunction): void
    {
        $this->addRoute($routeUri, 'POST', $commandCreateFunction);
    }
}