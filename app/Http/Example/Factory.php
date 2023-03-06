<?php

namespace App\Http\Example;

use App\Http\Example\Handler\ExampleHandler;
use Framework\DependencyInjection\DependencyInjection;
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