<?php

declare(strict_types=1);


namespace Therion86\Framework\Interfaces;

use Therion86\Framework\Routing\Route;

interface HttpRouterInterface
{
    /**
     * @return ResponseInterface
     */
    public function route(): ResponseInterface;


    /**
     * @return array<array<Route>>
     */
    public function getRoutes(): array;

    /**
     * @param string $routeUri
     * @param string $handler
     * @param array $parameters
     * @return self
     */
    public function registerGetRoute(string $routeUri, string $handler, array $parameters): self;

    /**
     * @param string $routeUri
     * @param string $handler
     * @param array $parameters
     * @return self
     */
    public function registerPostRoute(string $routeUri, string $handler, array $parameters): self;

    /**
     * @param string $routeUri
     * @param string $handler
     * @param array $parameters
     * @return self
     */
    public function registerPutRoute(string $routeUri, string $handler, array $parameters): self;

    /**
     * @param string $routeUri
     * @param string $handler
     * @param array $parameters
     * @return self
     */
    public function registerPatchRoute(string $routeUri, string $handler, array $parameters): self;

    /**
     * @param string $routeUri
     * @param string $handler
     * @param array $parameters
     * @return self
     */
    public function registerDeleteRoute(string $routeUri, string $handler, array $parameters): self;
}