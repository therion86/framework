<?php

declare(strict_types=1);

namespace framework\src\indexModule;

use framework\lib\request\Request;
use framework\lib\response\Response;
use framework\lib\routing\CommandInterface;
use framework\lib\response\ResponseInterface;

class Command implements CommandInterface
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function execute(): ResponseInterface
    {
        $test = $this->request->get('test');
        return new Response('Hello ' . $test);
    }
}