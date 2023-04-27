<?php

declare(strict_types=1);


namespace Therion86\App\Cli\Example;

use Therion86\App\Cli\Example\Handler\ExampleHandler;
use Therion86\Framework\DependencyInjection\DependencyInjection;
use Therion86\Framework\Interfaces\CliModuleFactoryInterface;
use Therion86\Framework\Routing\CliRouter;

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