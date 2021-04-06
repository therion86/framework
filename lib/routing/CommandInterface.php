<?php

declare(strict_types=1);

namespace framework\lib\routing;


use framework\lib\response\ResponseInterface;

interface CommandInterface
{

    public function execute(): ResponseInterface;

}