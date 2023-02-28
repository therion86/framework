<?php

namespace App\Example;

use App\Example\Handler\ExampleHandler;
use Framework\DependencyInjection\DependencyInjection;
use Framework\DependencyInjection\DI;
use Framework\Interfaces\ModuleFactoryInterface;
use Framework\Routing\Router;

class Factory implements ModuleFactoryInterface
{
    public function __construct(private DependencyInjection $di)
    {
        $this->di->getContainer()->register(ExampleHandler::class);
    }

    public function registerRoutes(Router $router): void
    {
        $router->registerGetRoute('exampleRoute', '/', ExampleHandler::class, []);
    }
}