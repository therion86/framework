<?php

namespace Framework\DependencyInjection;

abstract class DependencyInjection
{

    private DependencyInceptionContainer $container;

    public function __construct()
    {
        $this->container = new DependencyInceptionContainer();
    }


    public function getContainer(): DependencyInceptionContainer
    {
        return $this->container;
    }
}