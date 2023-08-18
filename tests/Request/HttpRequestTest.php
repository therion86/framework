<?php

declare(strict_types=1);


namespace Therion86\Test\Request;

use Therion86\Framework\Request\HttpRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Therion86\Framework\Request\HttpRequest
 */
class HttpRequestTest extends TestCase
{

    public function testFromGlobals(): void
    {
        $_SERVER['REQUEST_URI'] = '/1';
        $_SERVER['SCRIPT_NAME'] = '/index.php';
        $_SERVER['REQUEST_METHOD'] = $method = 'get';
        $_SERVER['HTTP_HOST'] = 'host';

        $http = HttpRequest::fromGlobals();

        $this->assertEquals(strtoupper($method), $http->getMethod());

        $this->assertEquals('', $http->getBody());

        $this->assertEquals([], $http->getHeaders());

        $this->assertNull($http->getParameter('test'));

        $this->assertNull($http->getRouteParameter('test'));

        $http->setRouteParameters(['id' => 1]);

        $this->assertEquals('1', $http->getRouteParameter('id'));

        $this->assertEquals('/1', $http->getUri());

        $this->assertEquals([], $http->getParameters());

        $this->assertEquals('host', $http->getHost());
    }
}