<?php

declare(strict_types=1);

namespace Framework\Interfaces;

interface HandlerInterface
{
    public function execute(RequestInterface $request, ResponseInterface $response): ResponseInterface;
}