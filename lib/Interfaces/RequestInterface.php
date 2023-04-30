<?php

namespace Therion86\Framework\Interfaces;

/**
 * @codeCoverageIgnore
 */
interface RequestInterface
{
    public static function fromGlobals(): self;

    public function getParameter(string $parameterName): string|array|null;

    public function getParameters(): array;

    public function getMethod(): string;

    public function getHeaders(): array;

    public function getUri(): string;

    public function getBody(): string;
}