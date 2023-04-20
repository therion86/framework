<?php

namespace App\Http\Example;

use App\Http\Example\Handler\ExampleHandler;
use Framework\DependencyInjection\DependencyInjection;
use Framework\Interfaces\ModuleFactoryInterface;
use Framework\Interfaces\RequestInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Request\HttpRequest;
use Framework\Routing\HttpRouter;

class Factory implements ModuleFactoryInterface
{
    public function __construct(private DependencyInjection $di)
    {
        $this->di->getContainer()->register(ExampleHandler::class);

    }

    public function registerRoutes(HttpRouter $router): void
    {
        $router->registerGetRoute(
            '/{id}',
            ExampleHandler::class,
            ['id' => '\d+']
        );
    }
}