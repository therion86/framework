<?php

declare(strict_types=1);

namespace framework\interfaces;

/**
 * @author Therion86
 */
interface RouteRegistererInterface
{

    /**
     * @return RouteInterface[]
     * @author Therion86
     */
    public function getRegisteredRoutes(): array;
}