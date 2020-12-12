<?php

namespace framework\response;

use JsonException;

/**
 * @author Therion86
 */
class JsonResponse extends HttpResponse
{

    /**
     * @param string[] $body
     * @throws JsonException
     * @author Therion86
     */
    public function __construct(array $body)
    {
        $jsonBody = json_encode($body, JSON_THROW_ON_ERROR);
        $status = 200;
        $headers['content-type'] = 'application/json';
        parent::__construct($this->getStream('php://memory', 'wb+'), $status, $headers);
        $this->response->getBody()->write($jsonBody);
    }

}