<?php

namespace framework\response;

use Exception;
use InvalidArgumentException;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\Stream;
use Psr\Http\Message\StreamInterface;
use framework\interfaces\HttpResponseInterface;

/**
 * @author Therion86
 */
class HttpResponse implements HttpResponseInterface
{

    protected Response $response;

    /**
     * @param string $body
     * @param int $status
     * @param array $headers
     * @author Therion86
     */
    public function __construct($body = 'php://memory', $status = 200, array $headers = [])
    {
        $this->response = new Response($body, $status, $headers);
    }

    /**
     * @param Exception $exception
     * @param array $data
     * @author Therion86
     */
    public function setInternalServerError(Exception $exception, array $data): void
    {
        $this->setStatusCode(500);
        $errorOutputArray = [
            'message' => $exception->getMessage(),
            'stack' => $exception->getTraceAsString(),
            'code' => $exception->getCode()
        ];
        $this->setBody(json_encode(array_merge($errorOutputArray, $data)));
    }

    /**
     * @param int $code
     * @author Therion86
     */
    public function setStatusCode(int $code): void
    {
        $this->response = $this->response->withStatus($code);
    }

    /**
     * @param string $body
     * @return void
     * @author Therion86
     */
    public function setBody(string $body): void
    {
        $this->response->getBody()->write($body);
    }

    /**
     * @return StreamInterface
     * @author Therion86
     */
    public function getBody(): StreamInterface
    {
        return $this->response->getBody();
    }

    /**
     * @return array
     * @author Therion86
     */
    public function getHeaders(): array
    {
        return $this->response->getHeaders();
    }

    /**
     * @return int
     * @author Therion86
     */
    public function getStatusCode(): int
    {
        return $this->response->getStatusCode();
    }

    /**
     * @param $stream
     * @param $modeIfNotInstance
     * @return StreamInterface|Stream
     * @author Therion86
     */
    protected function getStream($stream, $modeIfNotInstance)
    {
        if ($stream instanceof StreamInterface) {
            return $stream;
        }
        if (!is_string($stream) && !is_resource($stream)) {
            throw new InvalidArgumentException(
                'Stream must be a string stream resource identifier, '
                . 'an actual stream resource, '
                . 'or a Psr\Http\Message\StreamInterface implementation'
            );
        }
        return new Stream($stream, $modeIfNotInstance);
    }
}