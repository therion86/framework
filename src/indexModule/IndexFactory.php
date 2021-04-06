<?php


namespace framework\src\indexModule;

use framework\lib\routing\FactoryAbstract;

class IndexFactory extends FactoryAbstract
{
    public function registerRoutes(): void
    {
        $this->addRoute(
            '/',
            self::ROUTE_TYPE_GET,
            function() {
                return new Command($this->dependencyInjection->getRequest());
            }
        );
    }
}