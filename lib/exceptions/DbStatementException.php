<?php

declare(strict_types=1);

namespace framework\exceptions;

use Exception;

/**
 * @author Therion86
 */
class DbStatementException extends Exception
{

    /**
     * @param string $paramName
     * @return DbStatementException
     * @author Therion86
     */
    public static function paramNotFound(string $paramName)
    {
        $message = 'The param %s not found in query';
        return new self(sprintf($message, $paramName));
    }
}