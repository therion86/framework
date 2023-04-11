<?php

declare(strict_types=1);


namespace Test\DependencyInjection;

use App\Http\Example\Factory;
use App\Http\Example\Handler\ExampleHandler;
use Exception;
use Framework\DependencyInjection\HttpDependencyInjection;
use Framework\Interfaces\HttpRequestInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Request\HttpRequest;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @covers \Framework\DependencyInjection\HttpDependencyInjection
 */
class HttpDependencyInjectionTest extends TestCase
{

    public function testDiWasConstructed(): void
    {
        $_SERVER['REQUEST_URI'] = 'test?test=1';
        $_SERVER['SCRIPT_NAME'] = 'test';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([], []);

        $this->assertInstanceOf(HttpDependencyInjection::class, $di);
    }

    public function testModulesWhereAddedToContainer(): void
    {
        $_SERVER['REQUEST_URI'] = '/1';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';

        $di = new HttpDependencyInjection([Factory::class], []);
        $di->getRouter()->route();

        $this->assertInstanceOf(
            ExampleHandler::class,
            $di->getContainer()->load(ExampleHandler::class)
        );
    }

    public function testModulesFailedAddingToContainer(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Provided module factory must implement ModuleFactoryInterface');
        $di = new HttpDependencyInjection([\App\Cli\Example\Factory::class], []);
    }

    public function testCallableServicesWhereAddedToContainer(): void
    {
        $_SERVER['REQUEST_URI'] = '/1';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([], [HttpRequest::class => fn() => new stdClass()]);

        $this->assertInstanceOf(
            stdClass::class,
            $di->getContainer()->loadCallable(HttpRequest::class)
        );
    }

    public function testServicesWhereAddedToContainer(): void
    {
        $_SERVER['REQUEST_URI'] = '/1';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([], [HttpRequest::class => ['', '', [], [], '']]);

        $this->assertInstanceOf(
            HttpRequest::class,
            $di->getContainer()->load(HttpRequest::class)
        );
    }

    public function testGenerateResponseFails(): void
    {
        $_SERVER['REQUEST_URI'] = '/1';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([], [HttpRequest::class => ['', '', [], [], '']]);

        $di->getContainer()->registerCallable(ResponseInterface::class, fn() => new \stdClass());

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The registered response must be instance of ResponseInterface');
        $response = $di->generateResponse('');
    }

    public function testGetRequestFails(): void
    {
        $_SERVER['REQUEST_URI'] = '/1';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([], [HttpRequest::class => ['', '', [], [], '']]);

        $di->getContainer()->registerCallable(HttpRequestInterface::class, fn() => new \stdClass());

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The registered request must be instance of RequestInterface');
        $response = $di->getRequest('');
    }
}