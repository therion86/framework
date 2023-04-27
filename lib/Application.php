<?php

namespace Therion86\Framework;

use Exception;
use Therion86\Framework\DependencyInjection\CliDependencyInjection;
use Therion86\Framework\DependencyInjection\DependencyInjection;
use Therion86\Framework\DependencyInjection\HttpDependencyInjection;
use Therion86\Framework\Enums\AppType;

class Application
{
    /**
     * @throws Exception
     */
    public static function registerApp(AppType $appType, array $loadedModules, array $loadedServices): DependencyInjection
    {
        return match ($appType) {
            AppType::CLI => new CliDependencyInjection($loadedModules, $loadedServices),
            AppType::HTTP => new HttpDependencyInjection($loadedModules, $loadedServices)
        };
    }
}