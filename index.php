<?php

require "vendor/autoload.php";

$di = new \framework\lib\DependencyInjection();
try {
    $router = new \framework\lib\routing\Router($di);
    $di->register(new \framework\src\ModuleRegisterer($di), new \framework\src\PluginRegisterer());
    echo $router->printContent();
} catch (Exception $e) {
    header($_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error', true, 500);
    echo json_encode([
        'message' => $e->getMessage(),
        'stack' => $e->getTraceAsString(),
        'code' => $e->getCode()
    ]);
}
