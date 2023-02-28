<?php

declare(strict_types=1);

namespace Framework\Interfaces;

interface ResponseInterface
{
    public function send(): void;

    public function setBody(string $body): self;

    public function setHeaders(array $headers): self;

    public function setStatusCode(int $statusCode): self;
}