<?php

namespace Therion86\App\Http\Example;

use Therion86\App\Http\Example\Handler\ExampleHandler;
use Therion86\Framework\DependencyInjection\DependencyInjection;
use Therion86\Framework\Interfaces\ModuleFactoryInterface;
use Therion86\Framework\Routing\HttpHttpRouter;

class Factory implements ModuleFactoryInterface
{
    public function __construct(private DependencyInjection $di)
    {
        $this->di->getContainer()->register(ExampleHandler::class);

    }

    public function registerRoutes(HttpHttpRouter $router): void
    {
        $router->registerGetRoute(
            '/{id}',
            ExampleHandler::class,
            ['id' => '\d+']
        );
    }
}