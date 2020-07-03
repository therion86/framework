<?php

declare(strict_types=1);

namespace framework\request;

use framework\interfaces\HttpRequestInterface;
use Laminas\Diactoros\ServerRequest;

/**
 * @author Therion86
 */
class HttpRequest extends ServerRequest implements HttpRequestInterface
{

    /**
     * @param string $parameterName
     * @return mixed|null
     * @author Therion86
     */
    public function getParameter(string $parameterName)
    {
        $paramValue = $this->getAttribute($parameterName);
        $queryParams = $this->getQueryParams();
        if ('' === $paramValue && !array_key_exists($parameterName, $queryParams)) {
            return null;
        }
        if ('' !== $paramValue && null !== $paramValue) {
            return $paramValue;
        }
        if (array_key_exists($parameterName, $queryParams)) {
            return $queryParams[$parameterName];
        }
        return null;
    }

    /**
     * @return array
     * @author Therion86
     */
    public function getParameters(): array
    {
        return array_merge($this->getAttributes(), $this->getQueryParams());
    }
}