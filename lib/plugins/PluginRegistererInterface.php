<?php

namespace framework\lib\plugins;

interface PluginRegistererInterface
{
    public function registerPlugins(PluginContainer $pluginContainer);
}