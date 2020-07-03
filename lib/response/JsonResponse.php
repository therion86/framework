<?php

namespace framework\response;

/**
 * @author Therion86
 */
class JsonResponse extends HttpResponse
{

    /**
     * @param string[] $body
     * @author Therion86
     */
    public function __construct(array $body)
    {
        $body = json_encode($body);
        $status = 200;
        $headers['content-type'] = 'application/json';
        parent::__construct($this->getStream('php://memory', 'wb+'), $status, $headers);
        $this->response->getBody()->write($body);
    }

}