<?php

namespace framework\interfaces;

use Psr\Http\Message\StreamInterface;

/**
 * @author Therion86
 */
interface HttpResponseInterface
{

    /**
     * @return StreamInterface
     * @author Therion86
     */
    public function getBody(): StreamInterface;

    /**
     * @param string $body
     * @author Therion86
     */
    public function setBody(string $body): void;

    /**
     * @return array
     * @author Therion86
     */
    public function getHeaders(): array;

    /**
     * @return int
     * @author Therion86
     */
    public function getStatusCode(): int;

    /**
     * @param \Exception $exception
     * @param array $data
     * @author Therion86
     */
    public function setInternalServerError(\Exception $exception, array $data): void;

    /**
     * @param int $code
     * @author Therion86
     */
    public function setStatusCode(int $code): void;

}