<?php

namespace Framework\Response;

use Framework\Interfaces\ResponseInterface;

class HttpResponse implements ResponseInterface
{

    public function __construct(
        private string $body,
        private int $statusCode = 200,
        private array $headers = []
    ) {
    }

    /**
     * @codeCoverageIgnore
     */
    public function send(): void
    {
        // Setze den HTTP-Statuscode
        http_response_code($this->statusCode);

        // Setze die Header
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        // Sende den Body
        echo $this->body;
    }

    public function setBody(string $body): ResponseInterface
    {
        $this->body = $body;
        return $this;
    }

    public function setHeaders(array $headers): ResponseInterface
    {
        $this->headers = $headers;
        return $this;
    }

    public function setStatusCode(int $statusCode): ResponseInterface
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}