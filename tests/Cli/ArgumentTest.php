<?php

declare(strict_types=1);


namespace Test\Cli;

use Framework\Cli\Argument;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Framework\Cli\Argument
 */
class ArgumentTest extends TestCase
{
    public function testArgument()
    {

        $argument = new Argument($args = ['index.php', 'example', '--name=Test']);

        array_shift($args);

        $this->assertEquals($argument->getArgs(), $args);

        $this->assertEquals('Test',$argument->getArgValue('name'));

        $this->assertTrue($argument->hasArg('name'));

        $this->assertFalse($argument->hasArg('test'));

        $this->assertEquals('example', $argument->getMethod());
    }

    public function testArgumentWithSpaceBetweenValueAndName()
    {
        $argument = new Argument($args = ['index.php', 'example', '--name', 'Test']);

        $this->assertEquals('Test', $argument->getArgValue('name'));

    }

    public function testArgumentWithNonePropertyValue()
    {
        $argument = new Argument(['index.php', 'example', '--name']);

        $this->assertNull($argument->getArgValue('name'));

    }
}