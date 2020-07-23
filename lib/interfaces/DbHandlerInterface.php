<?php

declare(strict_types=1);

namespace framework\interfaces;

use framework\database\DbConnection;
use framework\database\DbStatement;

/**
 * @author Therion86
 */
interface DbHandlerInterface
{
    /**
     * @return DbConnectionInterface
     * @author Therion86
     */
    public function getConnection(): DbConnectionInterface;

    /**
     * @param string $statement
     * @return DbStatementInterface
     * @author Therion86
     */
    public function prepareStatement(string $statement): DbStatementInterface;
}