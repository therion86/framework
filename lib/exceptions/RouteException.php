<?php

declare(strict_types=1);

namespace framework\exceptions;

use Exception;

/**
 * @author Therion86
 */
final class RouteException extends Exception
{

    /**
     * @param string $routeName
     * @return RouteException
     * @author Therion86
     */
    public static function forNoPageDefined(string $routeName): RouteException
    {
        $message = 'No page for route %s was defined!';
        return new self(sprintf($message, $routeName));
    }

    /**
     * @param string $routeName
     * @return RouteException
     * @author Therion86
     */
    public static function forNoFactoryDefined(string $routeName): RouteException
    {
        $message = 'No factory for route %s was defined!';
        return new self(sprintf($message, $routeName));
    }

    /**
     * @param string $routeName
     * @return RouteException
     * @author Therion86
     */
    public static function forAlreadyExists(string $routeName): RouteException
    {
        $message = 'No route %s already Exists!';
        return new self(sprintf($message, $routeName));
    }

    /**
     * @param string $routeName
     * @param string $factoryClassName
     * @param string $pageClassName
     * @return RouteException
     * @author Therion86
     */
    public static function forNoCreateMethodDefined(
        string $routeName,
        string $factoryClassName,
        string $pageClassName
    ): RouteException {
        $message = 'No create method for page %s in factory %s in route %s defined!';
        return new self(sprintf($message, $pageClassName, $factoryClassName, $routeName));
    }

    /**
     * @param string $pageClassName
     * @return RouteException
     * @author Therion86
     */
    public static function forExecuteMethodNotFoundInPage(string $pageClassName): RouteException
    {
        $message = 'Execute action was not found in %s!';
        return new self(sprintf($message, $pageClassName));
    }

    /**
     * @return RouteException
     * @author Therion86
     */
    public static function forEmptyBody()
    {
        $message = 'Request gets empty body!';
        return new self($message);
    }
}