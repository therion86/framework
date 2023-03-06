<?php

namespace App\Http\Example\Handler;

use Framework\Interfaces\HandlerInterface;
use Framework\Interfaces\RequestInterface;
use Framework\Interfaces\ResponseInterface;

class ExampleHandler implements HandlerInterface
{

    public function execute(RequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        return $response->setBody('Hello World!');
    }
}