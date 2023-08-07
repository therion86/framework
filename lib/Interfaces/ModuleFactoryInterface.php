<?php

namespace Therion86\Framework\Interfaces;

use Therion86\Framework\Routing\HttpHttpRouter;

/**
 * @codeCoverageIgnore
 */
interface ModuleFactoryInterface
{

    public function registerRoutes(HttpHttpRouter $router): void;

}