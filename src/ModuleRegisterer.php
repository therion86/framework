<?php

declare(strict_types=1);

namespace framework\src;

use framework\lib\DependencyInjection;
use framework\lib\modules\ModuleRegistererInterface;
use framework\lib\plugins\PluginContainer;
use framework\src\indexModule\IndexFactory;

class ModuleRegisterer implements ModuleRegistererInterface
{
    private DependencyInjection $di;

    public function __construct(DependencyInjection $di)
    {
        $this->di = $di;
    }

    public function registerModules(PluginContainer $pluginContainer): void
    {
        $indexFactory = new IndexFactory($this->di);
        $indexFactory->registerRoutes($pluginContainer);
    }
}