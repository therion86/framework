<?php

use Therion86\Framework\Application;
use Therion86\Framework\DependencyInjection\CliDependencyInjection;
use Therion86\Framework\Enums\AppType;

include_once __DIR__ . '/../vendor/autoload.php';


if (!file_exists(__DIR__ . '/../config/cli-modules.php')) {
    throw new Exception('The app has no modules.php in folder config');
}


if (!file_exists(__DIR__ . '/../config/services.php')) {
    throw new Exception('The app has no services.php in folder config');
}

$loadedServices = include __DIR__ . '/../config/services.php';
$loadedModules = include __DIR__ . '/../config/cli-modules.php';

$di = Application::registerApp(AppType::CLI, $loadedModules, $loadedServices);
/* @var $di CliDependencyInjection */
$di->getRouter()->route();