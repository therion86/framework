<?php

namespace framework\lib\plugins;

class PluginContainer
{
    private array $plugins;

    public function __construct()
    {
        $this->plugins = [];
    }

    /**
     * @throws PluginAlreadyRegisteredException
     */
    public function addPlugin(string $name, callable $callable): void
    {
        if (array_key_exists($name, $this->plugins)) {
            throw new PluginAlreadyRegisteredException($name);
        }
        $this->plugins[$name] = $callable;
    }

    public function getPlugin(string $pluginName): \Closure
    {
        return $this->plugins[$pluginName] ?? throw new PluginNotRegisteredException($pluginName);
    }
}