<?php

declare(strict_types=1);

namespace cms\modules\index;

use cms\modules\index\page\IndexPage;
use framework\exceptions\RouteException;
use framework\interfaces\RouteInterface;
use framework\routing\RouteContainer;

/**
 * @author Therion86
 */
class IndexRoutes implements RouteInterface
{

    /**
     * @param RouteContainer $routeContainer
     * @return void
     * @throws RouteException
     * @author Therion86
     */
    public function addRoutes(RouteContainer $routeContainer): void
    {
        $routeContainer->addGet('/', IndexFactory::class, IndexPage::class);
    }

}