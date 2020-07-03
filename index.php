<?php

use cms\routes\RouteRegisterer;

require "vendor/autoload.php";
define('BASE_PATH', __DIR__);

$srcDir = BASE_PATH . '/src/modules';
$di = new framework\DependencyInjection('config.json');
try {
	$routing = new framework\routing\Routing($di, $srcDir, new RouteRegisterer());
	echo $routing->printContent();
} catch (Exception $e) {
	header($_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error', true, 500);
	echo json_encode([
		'message' => $e->getMessage(),
		'stack' => $e->getTraceAsString(),
		'code' => $e->getCode()
	]);
}
