<?php

declare(strict_types=1);

namespace framework\src\indexModule;

use framework\lib\modules\FactoryAbstract;
use framework\lib\plugins\PluginContainer;

class IndexFactory extends FactoryAbstract
{

    public function registerRoutes(PluginContainer $pluginContainer): void
    {
        $this->addGetRoute(
            '/',
            function() use ($pluginContainer) {
                return new Command(
                    $this->dependencyInjection->getRequest(),
                    $pluginContainer->getPlugin('DbHandler')()
                );
            }
        );
    }
}