<?php

namespace Framework\Interfaces;

use Framework\Routing\Router;

interface ModuleFactoryInterface
{

    public function registerRoutes(Router $router): void;

}