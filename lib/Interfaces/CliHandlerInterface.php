<?php

declare(strict_types=1);


namespace Framework\Interfaces;

use Framework\Cli\Argument;

interface CliHandlerInterface
{
    public function execute(Argument $arguments): void;
}