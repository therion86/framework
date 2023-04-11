<?php

declare(strict_types=1);


namespace App\Cli\Example\Handler;

use Framework\Cli\Argument;
use Framework\Cli\CliFunctions;
use Framework\Interfaces\CliHandlerInterface;

class ExampleHandler implements CliHandlerInterface
{
    public function __construct(private CliFunctions $cliFunctions)
    {
    }

    public function execute(Argument $arguments): void
    {
        $this->cliFunctions->writeLn($arguments->getArgValue('name'));
    }

}