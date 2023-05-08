<?php

namespace Therion86\App\Http\Example\Handler;

use Therion86\Framework\Interfaces\HandlerInterface;
use Therion86\Framework\Interfaces\HttpRequestInterface;
use Therion86\Framework\Interfaces\ResponseInterface;

class ExampleHandler implements HandlerInterface
{

    public function execute(
        HttpRequestInterface $request,
        ResponseInterface $response
    ): ResponseInterface {
        return $response->setBody('Hello World!');
    }
}