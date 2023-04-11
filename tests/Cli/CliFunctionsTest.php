<?php

declare(strict_types=1);


namespace Test\Cli;

use Framework\Cli\CliFunctions;
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