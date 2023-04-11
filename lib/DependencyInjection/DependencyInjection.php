<?php

namespace Framework\DependencyInjection;

abstract class DependencyInjection
{

    private DependencyInjectionContainer $container;

    public function __construct()
    {
        $this->container = new DependencyInjectionContainer();
    }


    public function getContainer(): DependencyInjectionContainer
    {
        return $this->container;
    }
}