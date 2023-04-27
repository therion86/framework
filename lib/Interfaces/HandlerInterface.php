<?php

declare(strict_types=1);

namespace Therion86\Framework\Interfaces;

/**
 * @codeCoverageIgnore
 */
interface HandlerInterface
{
    public function execute(HttpRequestInterface $request, ResponseInterface $response): ResponseInterface;
}