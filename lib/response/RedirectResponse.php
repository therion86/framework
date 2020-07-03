<?php

declare(strict_types=1);

namespace framework\response;

use InvalidArgumentException;
use Psr\Http\Message\UriInterface;
use framework\interfaces\HttpResponseInterface;

/**
 * @author Therion86
 */
class RedirectResponse extends HttpResponse implements HttpResponseInterface
{

    /**
     * @param string $url
     * @author Therion86
     */
    public function __construct(string $url)
    {
        if (!is_string($url) && !$url instanceof UriInterface) {
            throw new InvalidArgumentException(
                sprintf(
                    'Urls provided to %s MUST be a string',
                    __CLASS__
                )
            );
        }
        $headers = [];
        $headers['location'] = (string)$url;
        parent::__construct($this->getStream('php://memory', 'wb+'), 302, $headers);
    }
}