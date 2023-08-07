<?php

namespace Therion86\Framework\Interfaces;

use Therion86\Framework\Routing\HttpRouter;

/**
 * @codeCoverageIgnore
 */
interface ModuleFactoryInterface
{

    public function registerRoutes(HttpRouterInterface $router): void;

}