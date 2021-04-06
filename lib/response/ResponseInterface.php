<?php

declare(strict_types=1);

namespace framework\lib\response;


interface ResponseInterface
{

    public function getBody(): string;

    public function setHeader(string $header): void;

    public function getHeaders(): array;

    public function getStatusCode(): int;
}