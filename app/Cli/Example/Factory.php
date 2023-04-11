<?php

declare(strict_types=1);


namespace App\Cli\Example;

use App\Cli\Example\Handler\ExampleHandler;
use Framework\DependencyInjection\DependencyInjection;
use Framework\Interfaces\CliModuleFactoryInterface;
use Framework\Routing\CliRouter;

class Factory implements CliModuleFactoryInterface
{
    public function __construct(private DependencyInjection $di)
    {
        $this->di->getContainer()->register(ExampleHandler::class);
    }

    public function registerCommands(CliRouter $router): void
    {
        $router->registerCommand('example', ExampleHandler::class, ['name' => '\w+']);
    }

}