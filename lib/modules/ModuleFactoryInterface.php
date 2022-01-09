<?php

namespace framework\lib\modules;

use framework\lib\plugins\PluginContainer;

interface ModuleFactoryInterface
{
    public function registerRoutes(PluginContainer $pluginContainer): void;
}