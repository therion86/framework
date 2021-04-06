<?php


namespace framework\src;


use framework\lib\DependencyInjection;
use framework\src\indexModule\IndexFactory;

class ModuleRegisterer
{
    private DependencyInjection $di;

    public function __construct(DependencyInjection $di)
    {
        $this->di = $di;
    }

    public function registerModules(): void
    {
        $indexFactory = new IndexFactory($this->di);
        $indexFactory->registerRoutes();
    }

}