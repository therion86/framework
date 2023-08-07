<?php

declare(strict_types=1);


namespace Therion86\Test\Routing;

use Therion86\Framework\Routing\Route;
use PHPUnit\Framework\TestCase;
use Therion86\Framework\Routing\RouteType;

/**
 * @covers \Therion86\Framework\Routing\Route
 */
class RouteTest extends TestCase
{
    public function testRoute(): void
    {
        $uri = 'testUri';
        $method = RouteType::GET;
        $parameters =  [];
        $handler = 'someClass';
        $route = new Route($uri, $method, $parameters, $handler);

        $this->assertEquals($uri, $route->uri);
        $this->assertEquals($method->name, $route->method->name);
        $this->assertEquals($parameters, $route->parameters);
        $this->assertEquals($handler, $route->handler);
    }
}