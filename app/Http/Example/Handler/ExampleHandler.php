<?php

namespace App\Http\Example\Handler;

use Framework\Interfaces\HandlerInterface;
use Framework\Interfaces\HttpRequestInterface;
use Framework\Interfaces\RequestInterface;
use Framework\Interfaces\ResponseInterface;

class ExampleHandler implements HandlerInterface
{

    public function execute(
        HttpRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        return $response->setBody('Hello World!');
    }
}