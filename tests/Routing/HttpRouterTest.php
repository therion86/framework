<?php

declare(strict_types=1);


namespace Therion86\Test\Routing;

use Therion86\App\Http\Example\Factory;
use Therion86\App\Http\Example\Handler\ExampleHandler;
use Therion86\Framework\DependencyInjection\HttpDependencyInjection;
use Therion86\Framework\Exceptions\HandlerInterfaceNotFullfilledException;
use Therion86\Framework\Exceptions\HandlerNotFoundException;
use Therion86\Framework\Exceptions\RouteAlreadyExistsException;
use Therion86\Framework\Exceptions\RouteNotFoundException;
use PHPUnit\Framework\TestCase;
use Therion86\Framework\Routing\RouteType;

/**
 * @covers \Therion86\Framework\Routing\HttpHttpRouter
 */
class HttpRouterTest extends TestCase
{
    public function testRouter(): void
    {
        $_SERVER['REQUEST_URI'] = '/1';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([Factory::class], []);

        $router = $di->getRouter();

        $resp = $router->route();

        $this->assertEquals('Hello World!',$resp->getBody());
    }

    public function testRouteNotFoundForMethod(): void
    {
        $_SERVER['REQUEST_URI'] = '/1';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'post';
        $di = new HttpDependencyInjection([Factory::class], []);

        $router = $di->getRouter();

        $this->expectException(RouteNotFoundException::class);
        $router->route();
    }

    public function testRouteNotFound(): void
    {
        $_SERVER['REQUEST_URI'] = '/d';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([Factory::class], []);

        $router = $di->getRouter();

        $this->expectException(RouteNotFoundException::class);
        $router->route();
    }

    public function testHandlerNotFound(): void
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([Factory::class], []);

        $router = $di->getRouter();
        $router->registerGetRoute('/test', 'class', []);

        $this->expectException(HandlerNotFoundException::class);
        $router->route();
    }

    public function testHandlerInterfaceNotFullfilled(): void
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([Factory::class], []);

        $di->getContainer()->register(\stdClass::class);

        $router = $di->getRouter();
        $router->registerGetRoute('/test', \stdClass::class, []);

        $this->expectException(HandlerInterfaceNotFullfilledException::class);
        $router->route();
    }

    public function testRouteAlreadyRegistered(): void
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([Factory::class], []);

        $di->getContainer()->register(\stdClass::class);

        $router = $di->getRouter();
        $router->registerGetRoute('/test', \stdClass::class, []);
        $this->expectException(RouteAlreadyExistsException::class);
        $router->registerGetRoute('/test', \stdClass::class, []);
    }

    public function testPostRoute(): void
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'post';
        $di = new HttpDependencyInjection([Factory::class], []);


        $router = $di->getRouter();
        $router->registerPostRoute('/test', ExampleHandler::class, []);
        $resp = $router->route();

        $this->assertEquals('Hello World!',$resp->getBody());
    }

    public function testPutRoute(): void
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'put';
        $di = new HttpDependencyInjection([Factory::class], []);


        $router = $di->getRouter();
        $router->registerPutRoute('/test', ExampleHandler::class, []);
        $resp = $router->route();

        $this->assertEquals('Hello World!',$resp->getBody());
    }

    public function testDeleteRoute(): void
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'delete';
        $di = new HttpDependencyInjection([Factory::class], []);


        $router = $di->getRouter();
        $router->registerDeleteRoute('/test', ExampleHandler::class, []);
        $resp = $router->route();

        $this->assertEquals('Hello World!',$resp->getBody());
    }

    public function testPatchRoute(): void
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'patch';
        $di = new HttpDependencyInjection([Factory::class], []);


        $router = $di->getRouter();
        $router->registerPatchRoute('/test', ExampleHandler::class, []);
        $resp = $router->route();

        $this->assertEquals('/test', $router->getRoutes()[RouteType::PATCH->name]['/test']->uri);
        $this->assertEquals('Hello World!',$resp->getBody());
    }

}