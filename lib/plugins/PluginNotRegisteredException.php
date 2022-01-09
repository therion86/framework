<?php

namespace framework\lib\plugins;

use Exception;
use JetBrains\PhpStorm\Pure;

class PluginNotRegisteredException extends Exception
{
    #[Pure] public function __construct(string $pluginName)
    {
        parent::__construct('Plugin ' . $pluginName . ' is not Registered!');
    }
}