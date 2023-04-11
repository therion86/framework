<?php

namespace Framework\Interfaces;

use Framework\Routing\CliRouter;

interface CliModuleFactoryInterface
{

    public function registerCommands(CliRouter $router): void;

}