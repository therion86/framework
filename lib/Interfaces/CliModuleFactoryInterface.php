<?php

namespace Therion86\Framework\Interfaces;

use Therion86\Framework\Routing\CliRouter;

/**
 * @codeCoverageIgnore
 */
interface CliModuleFactoryInterface
{

    public function registerCommands(CliRouter $router): void;

}