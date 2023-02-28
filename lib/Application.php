<?php

namespace Framework;

use Framework\DependencyInjection\CliDependencyInjection;
use Framework\DependencyInjection\DependencyInjection;
use Framework\DependencyInjection\HttpDependencyInjection;
use Framework\Enums\AppType;

class Application
{

    public static function registerApp(AppType $appType, array $loadesModules): DependencyInjection
    {
        return match ($appType) {
            AppType::CLI => new CliDependencyInjection(),
            AppType::HTTP => new HttpDependencyInjection($loadesModules)
        };
    }
}