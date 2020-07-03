<?php

namespace framework\interfaces;

use framework\routing\RouteContainer;

/**
 * @author Therion86
 */
interface RouteInterface
{

    /**
     * @param RouteContainer $routeContainer
     * @return void
     * @author Therion86
     */
    public function addRoutes(RouteContainer $routeContainer): void;

}