<?php

declare(strict_types=1);


namespace Test\Routing;

use App\Http\Example\Factory;
use App\Http\Example\Handler\ExampleHandler;
use Framework\DependencyInjection\HttpDependencyInjection;
use Framework\Exceptions\HandlerInterfaceNotFullfilledException;
use Framework\Exceptions\HandlerNotFoundException;
use Framework\Exceptions\RouteAlreadyExistsException;
use Framework\Exceptions\RouteNotFoundException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Framework\Routing\HttpRouter
 */
class HttpRouterTest extends TestCase
{
    public function testRouter()
    {
        $_SERVER['REQUEST_URI'] = '/1';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([Factory::class], []);

        $router = $di->getRouter();

        $resp = $router->route();

        $this->assertEquals('Hello World!',$resp->getBody());
    }

    public function testRouteNotFoundForMethod()
    {
        $_SERVER['REQUEST_URI'] = '/1';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'post';
        $di = new HttpDependencyInjection([Factory::class], []);

        $router = $di->getRouter();

        $this->expectException(RouteNotFoundException::class);
        $router->route();
    }

    public function testRouteNotFound()
    {
        $_SERVER['REQUEST_URI'] = '/d';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'get';
        $di = new HttpDependencyInjection([Factory::class], []);

        $router = $di->getRouter();

        $this->expectException(RouteNotFoundException::class);
        $router->route();
    }

    public function testHandlerNotFound()
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

    public function testHandlerInterfaceNotFullfilled()
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

    public function testRouteAlreadyRegistered()
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

    public function testPostRoute()
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

    public function testPutRoute()
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

    public function testDeleteRoute()
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

    public function testPatchRoute()
    {
        $_SERVER['REQUEST_URI'] = '/test';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = 'patch';
        $di = new HttpDependencyInjection([Factory::class], []);


        $router = $di->getRouter();
        $router->registerPatchRoute('/test', ExampleHandler::class, []);
        $resp = $router->route();

        $this->assertEquals('Hello World!',$resp->getBody());
    }

}