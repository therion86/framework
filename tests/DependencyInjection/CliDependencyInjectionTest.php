<?php

declare(strict_types=1);

namespace Test\DependencyInjection;

use App\Cli\Example\Factory;
use App\Cli\Example\Handler\ExampleHandler;
use Exception;
use Framework\DependencyInjection\CliDependencyInjection;
use stdClass;


/**
 * @covers \Framework\DependencyInjection\CliDependencyInjection
 */
class CliDependencyInjectionTest extends \PHPUnit\Framework\TestCase
{

    public function testDiWasConstructed(): void
    {
        $di = new CliDependencyInjection([], []);

        $this->assertInstanceOf(CliDependencyInjection::class, $di);
    }

    /**
     * @return void
     * @throws \Framework\Exceptions\ClassNotRegisteredException
     * @throws \Framework\Exceptions\ConstructorParameterTypeNotFoundException
     * @throws \Framework\Exceptions\HandlerInterfaceNotFullfilledException
     * @throws \Framework\Exceptions\HandlerNotFoundException
     * @throws \Framework\Exceptions\RouteNotFoundException
     * @throws \ReflectionException
     * @covers \Framework\DependencyInjection\DependencyInjection
     */
    public function testModulesWhereAddedToContainer(): void
    {
        $_SERVER['argv'] = ['index.php', 'example', '--name=Test'];
        $di = new CliDependencyInjection([Factory::class], []);
        $di->getRouter()->route();

        $this->assertInstanceOf(
            ExampleHandler::class,
            $di->getContainer()->load(ExampleHandler::class)
        );
    }

    public function testModulesFailedAddingToContainer(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Provided module factory must implement CliModuleFactoryInterface');
        $di = new CliDependencyInjection([\App\Http\Example\Factory::class], []);
    }

    public function testCallableServicesWhereAddedToContainer(): void
    {
        $_SERVER['argv'] = ['index.php', 'example', '--name=Test'];
        $di = new CliDependencyInjection([], [\Framework\Request\HttpRequest::class => fn() => new stdClass()]);

        $this->assertInstanceOf(
            stdClass::class,
            $di->getContainer()->loadCallable(\Framework\Request\HttpRequest::class)
        );
    }

    public function testServicesWhereAddedToContainer(): void
    {
        $_SERVER['argv'] = ['index.php', 'example', '--name=Test'];
        $di = new CliDependencyInjection([], [\Framework\Request\HttpRequest::class => ['', '', [], [], '']]);

        $this->assertInstanceOf(
            \Framework\Request\HttpRequest::class,
            $di->getContainer()->load(\Framework\Request\HttpRequest::class)
        );
    }

}