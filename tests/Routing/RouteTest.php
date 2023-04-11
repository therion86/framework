<?php

declare(strict_types=1);


namespace Test\Routing;

use Framework\Routing\Route;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Framework\Routing\Route
 */
class RouteTest extends TestCase
{
    public function testRoute(): void
    {
        $uri = 'testUri';
        $method = 'get';
        $parameters =  [];
        $handler = 'someClass';
        $route = new Route($uri, $method, $parameters, $handler);

        $this->assertEquals($uri, $route->getUri());
        $this->assertEquals($method, $route->getMethod());
        $this->assertEquals($parameters, $route->getParameters());
        $this->assertEquals($handler, $route->getHandler());
    }
}