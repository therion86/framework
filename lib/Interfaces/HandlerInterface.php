<?php

declare(strict_types=1);

namespace Framework\Interfaces;

/**
 * @codeCoverageIgnore
 */
interface HandlerInterface
{
    public function execute(HttpRequestInterface $request, ResponseInterface $response): ResponseInterface;
}