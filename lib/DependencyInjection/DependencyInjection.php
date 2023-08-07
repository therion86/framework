<?php

namespace Therion86\Framework\DependencyInjection;

abstract class DependencyInjection
{

    private DependencyInjectionContainer $container;

    public function __construct()
    {
        $this->container = new DependencyInjectionContainer($this);
    }


    public function getContainer(): DependencyInjectionContainer
    {
        return $this->container;
    }
}