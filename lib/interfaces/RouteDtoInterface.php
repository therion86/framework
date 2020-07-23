<?php

declare(strict_types=1);

namespace framework\interfaces;

/**
 * @author Therion86
 */
interface RouteDtoInterface
{
    /**
     * @return string
     * @author Therion86
     */
    public function getType(): string;

    /**
     * @return string
     * @author Therion86
     */
    public function getRouteName(): string;

    /**
     * @return string
     * @author Therion86
     */
    public function getRouteMap(): string;

    /**
     * @return string
     * @author Therion86
     */
    public function getFactoryClassName(): string;

    /**
     * @return string
     * @author Therion86
     */
    public function getPageClassName(): string;
}