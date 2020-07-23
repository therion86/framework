<?php

declare(strict_types=1);

namespace framework\database;

use framework\interfaces\DbConnectionInterface;
use framework\interfaces\DbStatementInterface;

class DbConnection extends \PDO implements DbConnectionInterface
{

    /**
     * @param string $dsn
     * @param string $username
     * @param string $passwd
     * @author Therion86
     */
    public function __construct(string $dsn, string $username, string $passwd)
    {
        parent::__construct($dsn, $username, $passwd);
        $this->setAttribute(\PDO::ATTR_STATEMENT_CLASS, array(DbStatement::class, array($this)));
    }

    /**
     * @param string $statement
     * @param array $driver_options
     * @return bool|DbStatementInterface
     * @author Therion86
     */
    public function prepareStatement(string $statement, array $driver_options = null)
    {
        return parent::prepare($statement, $driver_options);
    }
}