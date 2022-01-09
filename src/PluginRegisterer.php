<?php

namespace framework\src;

use framework\lib\plugins\PluginContainer;
use framework\lib\plugins\PluginRegistererInterface;
use framework\src\dbPlugin\DbPluginFactory;

class PluginRegisterer implements PluginRegistererInterface
{
    public function registerPlugins(PluginContainer $pluginContainer): void
    {
        $pluginFactory = new DbPluginFactory();
        $pluginContainer->addPlugin('DbHandler', function() use ($pluginFactory) {
           return $pluginFactory->getDatabaseHandler();
        });
    }
}