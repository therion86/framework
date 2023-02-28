<?php
declare(strict_types=1);
require_once 'autoload.php';

use Framework\Application;
use Framework\DependencyInjection\HttpDependencyInjection;
use Framework\Enums\AppType;


if (! file_exists(__DIR__ . '/config/loadedModules.php')) {
    throw new Exception('The app has no loadedModules.php');
}
$loadedModules = include 'config/loadedModules.php';
$di = Application::registerApp(AppType::HTTP, $loadedModules);
try {
    /* @var HttpDependencyInjection $di */
    $di->getRouter()->route()->send();
} catch (Exception $exception) {
    echo "<pre>";
    echo $exception->getTraceAsString();
    echo "</pre>";
}