<?php

declare(strict_types=1);

namespace framework\interfaces;

/**
 * @author Therion86
 */
interface PageInterface
{
    /**
     * @param HttpRequestInterface $request
     * @param HttpResponseInterface $response
     * @return HttpResponseInterface
     * @author Therion86
     */
    public function execute(HttpRequestInterface $request, HttpResponseInterface $response): HttpResponseInterface;
}