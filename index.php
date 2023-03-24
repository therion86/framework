<?php
declare(strict_types=1);
require_once 'vendor/autoload.php';

use Framework\Application;
use Framework\DependencyInjection\HttpDependencyInjection;
use Framework\Enums\AppType;


if (! file_exists(__DIR__ . '/config/modules.php')) {
    throw new Exception('The app has no modules.php in folder config');
}

if (! file_exists(__DIR__ . '/config/services.php')) {
    throw new Exception('The app has no services.php in folder config');
}

$loadedModules = include __DIR__ . '/config/modules.php';
$loadedServices = include __DIR__ . '/config/services.php';

$di = Application::registerApp(AppType::HTTP, $loadedModules, $loadedServices);
try {
    /* @var HttpDependencyInjection $di */
    $di->getRouter()->route()->send();
} catch (Exception $exception) {
    echo "<pre>";
    echo $exception->getTraceAsString();
    echo "</pre>";
}