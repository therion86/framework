<?php

declare(strict_types=1);


namespace Therion86\App\Cli\Example\Handler;

use Therion86\Framework\Cli\Argument;
use Therion86\Framework\Cli\CliFormatOptions;
use Therion86\Framework\Cli\CliFunctions;
use Therion86\Framework\Interfaces\CliHandlerInterface;

class ExampleHandler implements CliHandlerInterface
{
    public function __construct(private CliFunctions $cliFunctions)
    {
    }

    public function execute(Argument $arguments): void
    {
        $this->cliFunctions->writeLn($arguments->getArgValue('name'), CliFormatOptions::BOLD, CliFormatOptions::COLOR_RED);
    }

}