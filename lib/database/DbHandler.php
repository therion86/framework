<?php

declare(strict_types=1);

namespace framework\database;

use framework\config\DbConfig;

/**
 * @author Therion86
 */
class DbHandler
{

    /**
     * @var DbConnection|null
     */
    private DbConnection $dbConnection;

    /**
     * @var string
     */
    private string $dsn;

    /**
     * @var string
     */
    private string $user;

    /**
     * @var string
     */
    private string $password;

    /**
     * @param DbConfig $dbConfig
     * @author Therion86
     */
    public function __construct(DbConfig $dbConfig)
    {
        $this->dsn = $dbConfig->getDsn();
        $this->user = $dbConfig->getDbUser();
        $this->password = $dbConfig->getPassword();
    }

    /**
     * @return DbConnection
     * @author Therion86
     */
    public function getConnection(): DbConnection
    {
        if (null === $this->dbConnection) {
            return $this->dbConnection = new DbConnection($this->dsn, $this->user, $this->password);
        }
        return $this->dbConnection;
    }

    /**
     * @param string $statement
     * @return DbStatement
     * @author Therion86
     */
    public function prepareStatement(string $statement): DbStatement
    {
        return $this->getConnection()->prepare($statement, []);
    }
}