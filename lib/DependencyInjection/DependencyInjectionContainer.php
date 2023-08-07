<?php

declare(strict_types=1);

namespace Therion86\Framework\DependencyInjection;

use Therion86\Framework\Exceptions\ClassNotRegisteredException;
use Therion86\Framework\Exceptions\ConstructorParameterTypeNotFoundException;
use ReflectionClass;
use ReflectionException;

class DependencyInjectionContainer
{

    public function __construct(private readonly DependencyInjection $dependencyInjection)
    {
    }

    private array $container = [];
    private array $parameters = [];
    private array $statics = [];

    public function register(string $classLabel, ?string $className = null, array $parameters = []): void
    {
        $this->container[$classLabel] = $className ?? $classLabel;
        if (!empty($parameters)) {
            $this->parameters[$classLabel] = $parameters;
        }
    }

    public function registerCallable(string $className, callable $callable): void
    {
        $this->statics[$className] = $callable;
    }

    /**
     * @template T
     * @param class-string<T> $className
     * @return T|null
     * @throws ReflectionException
     * @throws ClassNotRegisteredException
     * @throws ConstructorParameterTypeNotFoundException
     */
    public function load(string $className): ?object
    {
        if (in_array($className, [DependencyInjection::class, HttpDependencyInjection::class, CliDependencyInjection::class])) {
            return $this->dependencyInjection;
        }
        if (!isset($this->container[$className])) {
            throw new ClassNotRegisteredException('Class ' . $className . ' was not registered');
        }
        if (isset($this->parameters[$className])) {
            return $this->getObjectWithParameters($className);
        }
        return $this->getDependenciesByReflection($className);
    }

    public function loadCallable(string $className): object
    {
        if (!isset($this->statics[$className])) {
            throw new ClassNotRegisteredException('Class ' . $className . ' was not registered');
        }
        return $this->statics[$className]();
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

    /**
     * @template T
     * @param class-string<T> $className
     * @return T|null
     * @throws ReflectionException
     */
    private function getObjectWithParameters(string $className)
    {
        $parameters = $this->parameters[$className];
        if ($this->numericParameters($parameters)) {
            return (new ReflectionClass($className))->newInstanceArgs($this->parameters[$className]);
        }
        $ref = new ReflectionClass($className);
        $constructor = $ref->getConstructor();

        if (null === $constructor) {
            throw new ReflectionException('Class has no defined constructor but has construction parameters defined!');
        }
        $constParams = $constructor->getParameters();

        $sortedConstructionParams = [];
        foreach ($constParams as $parameterOrder => $parameter) {
            if (isset($parameters[$parameter->getName()])) {
                $sortedConstructionParams[$parameterOrder] = $parameters[$parameter->getName()];
            }
            if ($parameter->isOptional() && $parameter->isDefaultValueAvailable()) {
                $sortedConstructionParams[$parameterOrder] = $parameter->getDefaultValue();
            }

            if ($parameter->allowsNull()) {
                $sortedConstructionParams[$parameterOrder] = null;
            }
        }
        if (count($sortedConstructionParams) !== count($parameters)) {
            throw new ReflectionException('Parameters are not equal to the parameters wanted in constructor, maybe naming?');
        }
        return $ref->newInstanceArgs($sortedConstructionParams);
    }

    /**
     * @param string[] $array
     * @return bool
     */
    private function numericParameters(array $array): bool
    {
        return array_values($array) === $array;
    }
}