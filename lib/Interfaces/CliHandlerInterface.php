<?php

declare(strict_types=1);


namespace Therion86\Framework\Interfaces;

use Therion86\Framework\Cli\Argument;

/**
 * @codeCoverageIgnore
 */
interface CliHandlerInterface
{
    public function execute(Argument $arguments): void;
}