<?php

declare(strict_types=1);

namespace Therion86\Test;

use Therion86\App\Cli\Example\Factory;
use Therion86\Framework\Application;
use Therion86\Framework\DependencyInjection\CliDependencyInjection;
use Therion86\Framework\DependencyInjection\HttpDependencyInjection;
use Therion86\Framework\Enums\AppType;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Framework\Application
 */
class ApplicationTest extends TestCase
{


    public function testApplicationCli()
    {
        $di = Application::registerApp(
            AppType::CLI,
            [Factory::class],
            [
                \Framework\Request\HttpRequest::class => fn() => 'return',
                \PHPUnit\Framework\Test::class => []
            ]
        );
        $this->assertInstanceOf(CliDependencyInjection::class, $di);
    }

    public function testApplicationHttp()
    {
        $_SERVER['REQUEST_URI'] = 'index.php?test';
        $_SERVER['SCRIPT_NAME'] = '';
        $_SERVER['REQUEST_METHOD'] = '';
        $di = Application::registerApp(AppType::HTTP, [], []);
        $this->assertInstanceOf(HttpDependencyInjection::class, $di);
    }
}