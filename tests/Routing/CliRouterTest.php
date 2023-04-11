<?php

declare(strict_types=1);


namespace Test\Routing;

use App\Cli\Example\Factory;
use App\Cli\Example\Handler\ExampleHandler;
use Exception;
use Framework\DependencyInjection\CliDependencyInjection;
use Framework\Exceptions\HandlerInterfaceNotFullfilledException;
use Framework\Exceptions\HandlerNotFoundException;
use Framework\Exceptions\RouteAlreadyExistsException;
use Framework\Exceptions\RouteNotFoundException;

/**
 * @covers \Framework\Routing\CliRouter
 */
class CliRouterTest extends \PHPUnit\Framework\TestCase
{

    public function testCliRouter(): void
    {
        $_SERVER['argv'] = ['index.php', 'example', '--name=Test'];
        $di = new CliDependencyInjection([Factory::class], []);

        $cliRouter = $di->getRouter();

        $cliRouter->registerCommand('test', ExampleHandler::class, []);

        $cliRouter->route();
        $this->expectOutputString('Test' . PHP_EOL);
    }

    public function testMandatoryMehtodFails(): void
    {
        $_SERVER['argv'] = ['index.php'];
        $di = new CliDependencyInjection([Factory::class], []);

        $cliRouter = $di->getRouter();

        $cliRouter->registerCommand('test', ExampleHandler::class, []);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Mandatory function name was not set');
        $cliRouter->route();
    }

    public function testRouteNotFound(): void
    {
        $_SERVER['argv'] = ['index.php', 'test'];
        $di = new CliDependencyInjection([Factory::class], []);

        $cliRouter = $di->getRouter();


        $this->expectException(RouteNotFoundException::class);
        $cliRouter->route();
    }

    public function testHandlerNotFound(): void
    {
        $_SERVER['argv'] = ['index.php', 'test'];
        $di = new CliDependencyInjection([Factory::class], []);

        $cliRouter = $di->getRouter();
        $cliRouter->registerCommand('test', 'className', []);


        $this->expectException(HandlerNotFoundException::class);
        $cliRouter->route();
    }

    public function testHandlerNotFullfillInterface(): void
    {
        $_SERVER['argv'] = ['index.php', 'test'];
        $di = new CliDependencyInjection([Factory::class], []);

        $di->getContainer()->register(\stdClass::class);

        $cliRouter = $di->getRouter();
        $cliRouter->registerCommand('test', \stdClass::class, []);


        $this->expectException(HandlerInterfaceNotFullfilledException::class);
        $cliRouter->route();
    }

    public function testMandatoryParameterNotSet(): void
    {
        $_SERVER['argv'] = ['index.php', 'test'];
        $di = new CliDependencyInjection([Factory::class], []);


        $cliRouter = $di->getRouter();
        $cliRouter->registerCommand('test', ExampleHandler::class, ['name' => '\d+']);


        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Parameter name is mandatory but not set!');
        $cliRouter->route();
    }

    public function testMandatoryParameterValueNotSet(): void
    {
        $_SERVER['argv'] = ['index.php', 'test', '--name=tt'];
        $di = new CliDependencyInjection([Factory::class], []);


        $cliRouter = $di->getRouter();
        $cliRouter->registerCommand('test', ExampleHandler::class, ['name' => '\d+']);


        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Mandatory value of parameter (name) does not match to the expression!');
        $cliRouter->route();
    }

    public function testRouteAlreadyExists(): void
    {
        $_SERVER['argv'] = ['index.php', 'test'];
        $di = new CliDependencyInjection([Factory::class], []);


        $cliRouter = $di->getRouter();
        $cliRouter->registerCommand('test', ExampleHandler::class, []);
        $this->expectException(RouteAlreadyExistsException::class);
        $cliRouter->registerCommand('test', ExampleHandler::class, []);
    }
}