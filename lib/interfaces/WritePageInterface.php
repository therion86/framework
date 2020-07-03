<?php

declare(strict_types=1);

namespace framework\interfaces;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Therion86
 */
interface WritePageInterface
{

    /**
     * @param HttpRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @author Therion86
     */
    public function executeWrite(HttpRequestInterface $request, ResponseInterface $response): ResponseInterface;
}