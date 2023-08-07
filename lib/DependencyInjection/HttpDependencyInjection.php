<?php

namespace Therion86\Framework\DependencyInjection;

use Exception;
use Therion86\Framework\Exceptions\ClassNotRegisteredException;
use Therion86\Framework\Exceptions\ConstructorParameterTypeNotFoundException;
use Therion86\Framework\Interfaces\HttpRequestInterface;
use Therion86\Framework\Interfaces\ModuleFactoryInterface;
use Therion86\Framework\Interfaces\ResponseInterface;
use Therion86\Framework\Interfaces\HttpRouterInterface;
use Therion86\Framework\Request\HttpRequest;
use Therion86\Framework\Response\HttpResponse;
use Therion86\Framework\Routing\HttpRouter;
use Throwable;

class HttpDependencyInjection extends DependencyInjection
{
    private ?HttpRouter $router = null;

    /**
     *
     */
    public function __construct(array $loadedModules, array $loadedServices)
    {
        parent::__construct();
        foreach ($loadedServices as $dependencyLabel => $registeredValue) {
            if (is_callable($registeredValue)) {
                $this->getContainer()->registerCallable($dependencyLabel, $registeredValue);
                continue;
            }
            if (is_array($registeredValue)) {
                $this->getContainer()->register($dependencyLabel, $dependencyLabel, $registeredValue);
                continue;
            }
            $this->getContainer()->register($dependencyLabel, $registeredValue);
        }
        foreach ($loadedModules as $loadedModule) {
            $moduleFactory = new $loadedModule($this);
            if (!$moduleFactory instanceof ModuleFactoryInterface) {
                throw new Exception('Provided module factory must implement ModuleFactoryInterface');
            }
            $moduleFactory->registerRoutes($this->getRouter());
        }
    }

    /**
     * If no Router is registered in di the fallback is used
     *
     * @return HttpRouter
     * @throws ConstructorParameterTypeNotFoundException
     * @throws \ReflectionException
     */
    public function getRouter(): HttpRouter
    {
        if (null !== $this->router) {
            return $this->router;
        }
        try {
            return $this->router = $this->getContainer()->load(HttpRouterInterface::class);
        } catch (ClassNotRegisteredException) {
            return $this->router = new HttpRouter($this);
        }
    }

    /**
     * @throws Exception
     */
    public function generateResponse(string $body = '', int $statusCode = 200, array $headers = []): ResponseInterface
    {
        try {
            $response = $this->getContainer()->loadCallable(ResponseInterface::class);
        } catch (Throwable) {
            $response = new HttpResponse('');
        }

        if (!$response instanceof ResponseInterface) {
            throw new Exception('The registered response must be instance of ResponseInterface');
        }

        $response->setBody($body);
        $response->setStatusCode($statusCode);
        $response->setHeaders($headers);
        return $response;
    }

    /**
     * @throws Exception
     */
    public function getRequest(): HttpRequestInterface
    {
        try {
            $request = $this->getContainer()->loadCallable(HttpRequestInterface::class);
        } catch (Throwable) {
            // Default use HttpRequest if no request was set in di container
            $request = HttpRequest::fromGlobals();
        }
        if (!$request instanceof HttpRequestInterface) {
            throw new Exception('The registered request must be instance of RequestInterface');
        }
        return $request;
    }
}