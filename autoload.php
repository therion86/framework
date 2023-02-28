<?php

declare(strict_types=1);

$folderMapping = include 'config/config.php';

foreach ($folderMapping as $namespace => $path) {
    spl_autoload_register(static function ($className) use ($namespace, $path) {
        $classFile = str_replace('\\', DIRECTORY_SEPARATOR, $className) . '.php';
        $filePath = __DIR__ . '/'. str_ireplace($namespace, $path, $classFile);
        if (file_exists($filePath)) {
            require_once($filePath);
            return true;
        }
        return false;
    });
}
