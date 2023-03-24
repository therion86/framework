<?php

declare(strict_types=1);

namespace Framework\DependencyInjection;

use Framework\Exceptions\ClassNotRegisteredException;
use Framework\Interfaces\ConstructorParameterTypeNotFoundException;
use ReflectionClass;
use ReflectionException;

class DependencyInceptionContainer
{

    private array $container = [];
    private array $parameters = [];

    public function register(string $className, array $parameters = []): void
    {
        $this->container[$className] = $className;
        if (! empty($parameters)) {
            $this->parameters[$className] = $parameters;
        }
    }

    /**
     * @throws ReflectionException
     * @throws ClassNotRegisteredException
     * @throws ConstructorParameterTypeNotFoundException
     */
    public function load(string $className): ?object
    {
        if (!isset($this->container[$className])) {
            throw new ClassNotRegisteredException('Class ' . $className . ' was not registered');
        }

        if (isset($this->parameters[$className])) {
            return (new ReflectionClass($className))->newInstanceArgs($this->parameters[$className]);
        }
        return $this->getDependenciesByReflection($className);
    }

    /**
     * @throws ClassNotRegisteredException
     * @throws ConstructorParameterTypeNotFoundException
     * @throws ReflectionException
     */
    private function getDependenciesByReflection(string $className): ?object
    {
        $dependencies = [];
        $refClass = new ReflectionClass($this->container[$className]);
        if (null === $constructor = $refClass->getConstructor()) {
            return new $this->container[$className]();
        }
        $params = $constructor->getParameters();
        foreach ($params as $param) {
            $type = $param->getType();
            if (null === $type) {
                if (!$param->isDefaultValueAvailable()) {
                    throw new ConstructorParameterTypeNotFoundException(
                        'Could not resolve parameter type of the constructor in class . ' . $className
                    );
                }
                $dependencies[] = $param->getDefaultValue();
            } else {
                $dependencies[] = $this->load($type->getName());
            }
        }
        return $refClass->newInstanceArgs($dependencies);
    }
}