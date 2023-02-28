<?php

declare(strict_types=1);

namespace Framework\DependencyInjection;

use Framework\Exceptions\ClassNotRegisteredException;
use Framework\Interfaces\ConstructorParameterTypeNotFoundException;
use ReflectionClass;

class DependencyInceptionContainer
{

    private array $container = [];

    public function register(string $className)
    {
        $this->container[$className] = $className;
    }

    /**
     * @throws \ReflectionException
     * @throws ClassNotRegisteredException
     * @throws ConstructorParameterTypeNotFoundException
     */
    public function load(string $className)
    {
        if (!isset($this->container[$className])) {
            throw new ClassNotRegisteredException('Class ' . $className . ' was not registered');
        }
        $refClass = new ReflectionClass($this->container[$className]);
        if (null === $constructor = $refClass->getConstructor()) {
            return new $this->container[$className]();
        }
        $params = $constructor->getParameters();
        $dependencies = [];
        foreach ($params as $param) {
            $type = $param->getType();
            if (null === $type) {
                if (! $param->isDefaultValueAvailable()) {
                    throw new ConstructorParameterTypeNotFoundException('Could not resolve parameter type of the constructor in class . '. $className);
                }
                $dependencies[] = $param->getDefaultValue();
            } else {
                $dependencies[] = $this->load($type->getName());
            }

        }
        return $refClass->newInstanceArgs($dependencies);
    }
}