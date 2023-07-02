<?php

declare(strict_types=1);

namespace Therion86\Test\DependencyInjection;

use Therion86\App\Cli\Example\Factory;
use Therion86\App\Cli\Example\Handler\ExampleHandler;
use Exception;
use Therion86\Framework\DependencyInjection\CliDependencyInjection;
use stdClass;


/**
 * @covers \Therion86\Framework\DependencyInjection\CliDependencyInjection
 * @covers \Therion86\Framework\DependencyInjection\DependencyInjection
 */
class CliDependencyInjectionTest extends \PHPUnit\Framework\TestCase
{

    public function testDiWasConstructed(): void
    {
        $di = new CliDependencyInjection([], []);

        $this->assertInstanceOf(CliDependencyInjection::class, $di);
    }

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
        $di = new CliDependencyInjection([\Therion86\App\Http\Example\Factory::class], []);
    }

    public function testCallableServicesWhereAddedToContainer(): void
    {
        $_SERVER['argv'] = ['index.php', 'example', '--name=Test'];
        $di = new CliDependencyInjection([], [\Therion86\Framework\Request\HttpRequest::class => fn() => new stdClass()]);

        $this->assertInstanceOf(
            stdClass::class,
            $di->getContainer()->loadCallable(\Therion86\Framework\Request\HttpRequest::class)
        );
    }

    public function testServicesWhereAddedToContainerWithParam(): void
    {
        $_SERVER['argv'] = ['index.php', 'example', '--name=Test'];
        $di = new CliDependencyInjection([], [\Therion86\Framework\Request\HttpRequest::class => ['', '', [], [], '']]);

        $this->assertInstanceOf(
            \Therion86\Framework\Request\HttpRequest::class,
            $di->getContainer()->load(\Therion86\Framework\Request\HttpRequest::class)
        );
    }

    public function testServicesWhereAddedToContainerWithClassName(): void
    {
        $_SERVER['argv'] = ['index.php', 'example', '--name=Test'];
        $di = new CliDependencyInjection([], [CliTestInterface::class => CliTestClass::class]);

        $this->assertInstanceOf(
            CliTestClass::class,
            $di->getContainer()->load(CliTestInterface::class)
        );
    }
}

class CliTestClass implements CliTestInterface {
    public function testFunction(): void {

    }
}

interface CliTestInterface {
    public function testFunction(): void;
}