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
}