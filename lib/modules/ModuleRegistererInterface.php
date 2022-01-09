<?php

namespace framework\lib\modules;

use framework\lib\plugins\PluginContainer;

interface ModuleRegistererInterface
{
    public function registerModules(PluginContainer $pluginContainer): void;
}