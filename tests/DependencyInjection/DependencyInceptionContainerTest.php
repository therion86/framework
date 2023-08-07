<?php

declare(strict_types=1);


namespace Therion86\Test\DependencyInjection;

use Therion86\Framework\DependencyInjection\DependencyInjectionContainer;
use Therion86\Framework\DependencyInjection\HttpDependencyInjection;
use Therion86\Framework\Exceptions\ClassNotRegisteredException;
use Therion86\Framework\Exceptions\ConstructorParameterTypeNotFoundException;
use Therion86\Framework\Request\HttpRequest;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Therion86\Framework\DependencyInjection\DependencyInjectionContainer
 */
class DependencyInceptionContainerTest extends TestCase
{

    public function testRegister(): void
    {
        $di = new HttpDependencyInjection([], []);
        $dic = new DependencyInjectionContainer($di);
        $dic->register(\stdClass::class);

        $this->assertInstanceOf(\stdClass::class, $dic->load(\stdClass::class));
    }

    public function testRegisterWithParams(): void
    {
        $di = new HttpDependencyInjection([], []);
        $dic = new DependencyInjectionContainer($di);
        $dic->register(HttpRequest::class, HttpRequest::class, ['', '', [],[],'']);

        $this->assertInstanceOf(HttpRequest::class, $dic->load(HttpRequest::class));
    }


    public function testRegisterCallable(): void
    {
        $di = new HttpDependencyInjection([], []);
        $dic = new DependencyInjectionContainer($di);
        $dic->registerCallable(\stdClass::class, fn() => new \stdClass());

        $this->assertInstanceOf(\stdClass::class, $dic->loadCallable(\stdClass::class));
    }


    public function testLoadClassNotRegistered(): void
    {
        $di = new HttpDependencyInjection([], []);
        $dic = new DependencyInjectionContainer($di);

        $this->expectException(ClassNotRegisteredException::class);
        $dic->load(\stdClass::class);
    }

    public function testLoadCallableClassNotRegistered(): void
    {
        $di = new HttpDependencyInjection([], []);
        $dic = new DependencyInjectionContainer($di);

        $this->expectException(ClassNotRegisteredException::class);
        $dic->loadCallable(\stdClass::class);
    }

    public function testConstructorParameterTypeNotFoundException(): void
    {
        $di = new HttpDependencyInjection([], []);
        $dic = new DependencyInjectionContainer($di);
        $dic->register(TestCaseNoType::class);

        $this->expectException(ConstructorParameterTypeNotFoundException::class);
        $dic->load(TestCaseNoType::class);
    }

    public function testGetDependenciesByReflectionWithType(): void
    {
        $di = new HttpDependencyInjection([], []);
        $dic = new DependencyInjectionContainer($di);
        $dic->register(TestCaseType::class);

        $this->assertInstanceOf(TestCaseType::class, $dic->load(TestCaseType::class));
    }

    public function testGetDependenciesByReflectionWithSubclass(): void
    {
        $di = new HttpDependencyInjection([], []);
        $dic = new DependencyInjectionContainer($di);
        $dic->register(TestCaseType::class);

        $dic->register(TestCaseSubClass::class);


        $this->assertInstanceOf(TestCaseSubClass::class, $dic->load(TestCaseSubClass::class));
    }

    public function testRegisterClassWithArguments(): void
    {
        $di = new HttpDependencyInjection([], []);
        $dic = new DependencyInjectionContainer($di);
        $dic->register(TestCaseType::class, null, ['value' => 'string']);

        $this->assertInstanceOf(TestCaseType::class, $dic->load(TestCaseType::class));
    }

    public function testNoConstructor(): void
    {
        $di = new HttpDependencyInjection([], []);
        $dic = new DependencyInjectionContainer($di);
        $dic->register(TestCaseNoConstructor::class, null, ['value' => 'string']);

        $this->expectException(\ReflectionException::class);
        $this->expectExceptionMessage('Class has no defined constructor but has construction parameters defined!');
        $dic->load(TestCaseNoConstructor::class);
    }

    public function testParametersNotEqual(): void
    {
        $di = new HttpDependencyInjection([], []);
        $dic = new DependencyInjectionContainer($di);
        $dic->register(TestCaseType::class, null, ['value' => 'string', 'test' => 'test']);

        $this->expectException(\ReflectionException::class);
        $this->expectExceptionMessage('Parameters are not equal to the parameters wanted in constructor, maybe naming?');
        $dic->load(TestCaseType::class);
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

class TestCaseNoConstructor {

}