<?php

declare(strict_types=1);


namespace Test\DependencyInjection;

use Framework\DependencyInjection\DependencyInjectionContainer;
use Framework\Exceptions\ClassNotRegisteredException;
use Framework\Exceptions\ConstructorParameterTypeNotFoundException;
use Framework\Request\HttpRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Framework\DependencyInjection\DependencyInjectionContainer
 */
class DependencyInceptionContainerTest extends TestCase
{

    public function testRegister(): void
    {
        $dic = new DependencyInjectionContainer();
        $dic->register(\stdClass::class);

        $this->assertInstanceOf(\stdClass::class, $dic->load(\stdClass::class));
    }

    public function testRegisterWithParams(): void
    {
        $dic = new DependencyInjectionContainer();
        $dic->register(HttpRequest::class, HttpRequest::class, ['', '', [],[],'']);

        $this->assertInstanceOf(HttpRequest::class, $dic->load(HttpRequest::class));
    }


    public function testRegisterCallable(): void
    {
        $dic = new DependencyInjectionContainer();
        $dic->registerCallable(\stdClass::class, fn() => new \stdClass());

        $this->assertInstanceOf(\stdClass::class, $dic->loadCallable(\stdClass::class));
    }


    public function testLoadClassNotRegistered(): void
    {
        $dic = new DependencyInjectionContainer();

        $this->expectException(ClassNotRegisteredException::class);
        $dic->load(\stdClass::class);
    }

    public function testLoadCallableClassNotRegistered(): void
    {
        $dic = new DependencyInjectionContainer();

        $this->expectException(ClassNotRegisteredException::class);
        $dic->loadCallable(\stdClass::class);
    }

    public function testConstructorParameterTypeNotFoundException(): void
    {
        $dic = new DependencyInjectionContainer();
        $dic->register(TestCaseNoType::class);

        $this->expectException(ConstructorParameterTypeNotFoundException::class);
        $dic->load(TestCaseNoType::class);
    }

    public function testGetDependenciesByReflectionWithType(): void
    {
        $dic = new DependencyInjectionContainer();
        $dic->register(TestCaseType::class);

        $this->assertInstanceOf(TestCaseType::class, $dic->load(TestCaseType::class));
    }

    public function testGetDependenciesByReflectionWithSubclass(): void
    {
        $dic = new DependencyInjectionContainer();
        $dic->register(TestCaseType::class);

        $dic->register(TestCaseSubClass::class);


        $this->assertInstanceOf(TestCaseSubClass::class, $dic->load(TestCaseSubClass::class));
    }
}

class TestCaseNoType {
    public function __construct($value)
    {
    }
}

class TestCaseType {
    public function __construct($value = null)
    {
    }
}

class TestCaseSubClass {
    public function __construct(TestCaseType $type)
    {
    }
}