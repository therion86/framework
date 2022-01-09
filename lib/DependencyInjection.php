<?php

declare(strict_types=1);

namespace framework\lib;

use framework\lib\modules\ModuleRegistererInterface;
use framework\lib\plugins\PluginContainer;
use framework\lib\plugins\PluginRegistererInterface;
use framework\lib\request\Request;
use framework\lib\routing\RouteContainer;
use JetBrains\PhpStorm\Pure;

class DependencyInjection
{

    private ?Request $request;
    private RouteContainer $registeredRoutes;
    private PluginContainer $pluginContainer;

    #[Pure] public function __construct()
    {
        $this->registeredRoutes = new RouteContainer();
        $this->pluginContainer = new PluginContainer();
    }

    #[Pure] public function getRequest(): Request
    {
        return $this->request ?? new Request();
    }

    public function getRegisteredRoutes(): RouteContainer
    {
        return $this->registeredRoutes;
    }

    public function register(ModuleRegistererInterface $moduleRegisterer, ?PluginRegistererInterface $pluginRegisterer): void
    {
        if (null !== $pluginRegisterer) {
            $pluginRegisterer->registerPlugins($this->getPluginContainer());
        }
        $moduleRegisterer->registerModules($this->getPluginContainer());
    }

    public function getPluginContainer(): PluginContainer
    {
        return $this->pluginContainer;
    }
}