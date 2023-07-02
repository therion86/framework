<?php

declare(strict_types=1);


namespace Therion86\Test\Routing;

use Therion86\Framework\Routing\Route;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Therion86\Framework\Routing\Route
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