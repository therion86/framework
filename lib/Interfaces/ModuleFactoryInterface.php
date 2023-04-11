<?php

namespace Framework\Interfaces;

use Framework\Routing\HttpRouter;

/**
 * @codeCoverageIgnore
 */
interface ModuleFactoryInterface
{

    public function registerRoutes(HttpRouter $router): void;

}