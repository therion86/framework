<?php

namespace Framework\DependencyInjection;

use Exception;
use Framework\Interfaces\ModuleFactoryInterface;
use Framework\Interfaces\RequestInterface;
use Framework\Interfaces\ResponseInterface;
use Framework\Request\HttpRequest;
use Framework\Response\JsonResponse;
use Framework\Routing\Router;

class HttpDependencyInjection extends DependencyInjection
{
    private Router $router;
    private RequestInterface $request;


    public function __construct(array $loadedModules)
    {
        parent::__construct();
        $this->request = HttpRequest::fromGlobals();
        $this->router = new Router($this);
        foreach ($loadedModules as $loadedModule) {
            $moduleFactory = new $loadedModule($this);
            if (! $moduleFactory instanceof ModuleFactoryInterface) {
                throw new Exception('Provided module factory must implement ModuleFactoryInterface');
            }
            $moduleFactory->registerRoutes($this->router);
        }
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function getRouter(): Router
    {
        return $this->router;
    }

    public function generateResponse(string $body = '', int $statusCode = 200, array $headers = []): ResponseInterface
    {
        return new JsonResponse($body, $statusCode, $headers);
    }
}