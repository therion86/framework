<?php

namespace Framework;

use Exception;
use Framework\DependencyInjection\CliDependencyInjection;
use Framework\DependencyInjection\DependencyInjection;
use Framework\DependencyInjection\HttpDependencyInjection;
use Framework\Enums\AppType;

class Application
{
    /**
     * @throws Exception
     */
    public static function registerApp(AppType $appType, array $loadedModules, array $loadedServices): DependencyInjection
    {
        return match ($appType) {
            AppType::CLI => new CliDependencyInjection(),
            AppType::HTTP => new HttpDependencyInjection($loadedModules, $loadedServices)
        };
    }
}