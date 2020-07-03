<?php

declare(strict_types=1);

namespace framework\interfaces;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @author Therion86
 */
interface ReadWritePageInterface
{

    /**
     * @param HttpRequestInterface $request
     * @param HttpResponseInterface $response
     * @return HttpResponseInterface
     * @author Therion86
     */
    public function executeRead(HttpRequestInterface $request, HttpResponseInterface $response): HttpResponseInterface;

    /**
     * @param HttpRequestInterface $request
     * @param HttpResponseInterface $response
     * @return HttpResponseInterface
     * @author Therion86
     */
    public function executeWrite(HttpRequestInterface $request, HttpResponseInterface $response): HttpResponseInterface;
}