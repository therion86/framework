<?php

namespace Therion86\Framework\DependencyInjection;


use Therion86\Framework\Cli\Argument;
use Therion86\Framework\Cli\CliFunctions;
use Therion86\Framework\Interfaces\CliModuleFactoryInterface;
use Therion86\Framework\Routing\CliRouter;

class CliDependencyInjection extends DependencyInjection
{
    private CliRouter $router;

    public function __construct(array $loadedModules, array $loadedServices)
    {
        parent::__construct();
        $this->router = new CliRouter($this, new Argument($_SERVER['argv']));
        foreach ($loadedModules as $loadedModule) {
            $moduleFactory = new $loadedModule($this);
            if (!$moduleFactory instanceof CliModuleFactoryInterface) {
                throw new \Exception('Provided module factory must implement CliModuleFactoryInterface');
            }
            $moduleFactory->registerCommands($this->router);
        }


        foreach ($loadedServices as $dependencyLabel => $registeredValue) {
            if (is_callable($registeredValue)) {
                $this->getContainer()->registerCallable($dependencyLabel, $registeredValue);
                continue;
            }
            if (is_array($registeredValue)) {
                $this->getContainer()->register($dependencyLabel, $dependencyLabel, $registeredValue);
                continue;
            }
            $this->getContainer()->register($dependencyLabel, $registeredValue);
        }

        // Always register cli functions for cli handler
        $this->getContainer()->register(CliFunctions::class);
    }

    public function getRouter(): CliRouter
    {
        return $this->router;
    }
}