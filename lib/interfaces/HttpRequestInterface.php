<?php

namespace framework\interfaces;

/**
 * @author Therion86
 */
interface HttpRequestInterface
{

    /**
     * @param string $parameterName
     * @return mixed
     * @author Therion86
     */
    public function getParameter(string $parameterName);

    /**
     * @return array
     * @author Therion86
     */
    public function getParameters(): array;
}