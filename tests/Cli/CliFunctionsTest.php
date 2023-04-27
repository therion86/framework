<?php

declare(strict_types=1);


namespace Therion86\Test\Cli;

use Therion86\Framework\Cli\CliFunctions;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Framework\Cli\CliFunctions
 */
class CliFunctionsTest extends TestCase
{

    public function testCliFunctions()
    {
        $cliFunctions = new CliFunctions();
        $this->expectOutputString('test' . PHP_EOL . 'test');
        $cliFunctions->writeLn('test');
        $cliFunctions->write('test');

    }
}