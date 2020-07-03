<?php
require "vendor/autoload.php";
define('BASE_PATH', __DIR__);
ini_set('session.save_path',__DIR__  . '/session');
if (! isset($_SESSION)){
    session_start();
}
$srcDir = realpath(__DIR__) . '/src/modules';
$di = new framework\DependencyInjection('config.json');
try {
	$routing = new framework\routing\Routing($di, $srcDir, new \cms\routes\RouteRegisterer());
	echo $routing->printContent();
} catch (Exception $e) {
	header($_SERVER["SERVER_PROTOCOL"] . ' 500 Internal Server Error', true, 500);
	echo json_encode([
		'message' => $e->getMessage(),
		'stack' => $e->getTraceAsString(),
		'code' => $e->getCode()
	]);
}
