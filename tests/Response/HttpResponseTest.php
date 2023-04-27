<?php

declare(strict_types=1);


namespace Therion86\Test\Response;

use Therion86\Framework\Response\HttpResponse;
use PHPUnit\Framework\TestCase;

class HttpResponseTest extends TestCase
{

    public function testHttpResponse(): void
    {
        $resp = new HttpResponse('testBody');

        $this->assertEquals('testBody', $resp->getBody());

        $this->assertEquals(200, $resp->getStatusCode());

        $this->assertEquals([], $resp->getHeaders());

        $resp->setStatusCode(400);
        $this->assertEquals(400, $resp->getStatusCode());

        $resp->setBody('anotherBody');
        $this->assertEquals('anotherBody', $resp->getBody());

        $resp->setHeaders($headers = ['headername' => 'headerValue']);
        $this->assertEquals($headers, $resp->getHeaders());

    }

}