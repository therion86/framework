<?php

declare(strict_types=1);

namespace cms\routes;

use cms\modules\index\IndexRoutes;
use framework\interfaces\RouteInterface;
use framework\interfaces\RouteRegistererInterface;

/**
 * @author Therion86
 */
class RouteRegisterer implements RouteRegistererInterface
{

    /**
     * @var RouteInterface[]
     */
    private array $registeredRoutes;

    /**
     * @author Therion86
     */
    public function __construct()
    {
        $this->registerRoutes();
    }

    /**
     * @return void
     * @author Therion86
     */
    private function registerRoutes()
    {
        $this->registeredRoutes[] = new IndexRoutes();
    }

    /**
     * @return RouteInterface[]
     * @author Therion86
     */
    public function getRegisteredRoutes(): array
    {
        return $this->registeredRoutes;
    }
}