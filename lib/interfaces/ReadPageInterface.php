<?php

declare(strict_types=1);

namespace framework\interfaces;

/**
 * @author Therion86
 */
interface ReadPageInterface
{

    /**
     * @param HttpRequestInterface $request
     * @param HttpResponseInterface $response
     * @return HttpResponseInterface
     * @author Therion86
     */
    public function executeRead(HttpRequestInterface $request, HttpResponseInterface $response): HttpResponseInterface;

}