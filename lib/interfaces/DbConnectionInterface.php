<?php

declare(strict_types=1);

namespace framework\interfaces;

use framework\database\DbStatement;

/**
 * @author Therion86
 */
interface DbConnectionInterface
{
    /**
     * @param string $statement
     * @param array $driver_options
     * @return bool|DbStatement
     * @author Therion86
     */
    public function prepareStatement(string $statement, array $driver_options);
}