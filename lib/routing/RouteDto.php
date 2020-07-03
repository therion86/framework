<?php

declare(strict_types=1);

namespace framework\routing;

/**
 * @author Therion86
 */
class RouteDto
{

    private string $type;

    private string $routeName;

    private string $routeMap;

    private string $factoryClassName;

    private string $pageClassName;

    /**
     * @param string $type
     * @param string $routeName
     * @param string $routeMap
     * @param string $factoryClassName
     * @param string $pageClassName
     * @author Therion86
     */
    public function __construct(
        string $type,
        string $routeName,
        string $routeMap,
        string $factoryClassName,
        string $pageClassName
    ) {
        $this->type = $type;
        $this->routeName = $routeName;
        $this->routeMap = $routeMap;
        $this->factoryClassName = $factoryClassName;
        $this->pageClassName = $pageClassName;
    }

    /**
     * @return string
     * @author Therion86
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     * @author Therion86
     */
    public function getRouteName(): string
    {
        return $this->routeName;
    }

    /**
     * @return string
     * @author Therion86
     */
    public function getRouteMap(): string
    {
        return $this->routeMap;
    }

    /**
     * @return string
     * @author Therion86
     */
    public function getFactoryClassName(): string
    {
        return $this->factoryClassName;
    }

    /**
     * @return string
     * @author Therion86
     */
    public function getPageClassName(): string
    {
        return $this->pageClassName;
    }
}