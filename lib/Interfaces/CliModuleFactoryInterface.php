<?php

namespace Framework\Interfaces;

use Framework\Routing\CliRouter;

/**
 * @codeCoverageIgnore
 */
interface CliModuleFactoryInterface
{

    public function registerCommands(CliRouter $router): void;

}