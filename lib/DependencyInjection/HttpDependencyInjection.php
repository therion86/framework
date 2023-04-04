<?php

namespace Framework\DependencyInjection;

use Exception;
use Framework\Exceptions\ClassNotRegisteredException;
use Framework\Interfaces\HttpRequestInterface;
use Framework\Interfaces\ModuleFactoryInterface;
use Framework\Interfaces\RequestInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Request\HttpRequest;
use Framework\Response\JsonResponse;
use Framework\Routing\Router;
use Throwable;

class HttpDependencyInjection extends DependencyInjection
{
    private Router $router;

    public function __construct(array $loadedModules, array $loadedServices)
    {
        parent::__construct();
        $this->router = new Router($this);
        foreach ($loadedModules as $loadedModule) {
            $moduleFactory = new $loadedModule($this);
            if (!$moduleFactory instanceof ModuleFactoryInterface) {
                throw new Exception('Provided module factory must implement ModuleFactoryInterface');
            }
            $moduleFactory->registerRoutes($this->router);
        }
        foreach ($loadedServices as $serviceName => $constructionParameters) {
            if (is_callable($constructionParameters)) {
                $this->getContainer()->registerStatic($serviceName, $constructionParameters);
                continue;
            }
            $this->getContainer()->register($serviceName, $constructionParameters);
        }
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    // TODO: replaceable for requests and renaming to only Response (because there is no json :))

    public function generateResponse(string $body = '', int $statusCode = 200, array $headers = []): ResponseInterface
    {
        return new JsonResponse($body, $statusCode, $headers);
    }

    /**
     * @throws Exception
     */
    public function getRequest(): HttpRequestInterface
    {
        try {
            $request = $this->getContainer()->loadStatic(HttpRequestInterface::class);
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