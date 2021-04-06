<?php


namespace framework\lib\response;


class Response implements ResponseInterface
{

    private string $body;
    private int $httpStatus;
    private array $headers;

    public function __construct(string $body, int $httpStatus = 200, array $headers = [])
    {
        $this->body = $body;
        $this->httpStatus = $httpStatus;
        $this->headers = $headers;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setHeader(string $header): void
    {
        $this->headers[] = $header;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getStatusCode(): int
    {
        return $this->httpStatus;
    }
}