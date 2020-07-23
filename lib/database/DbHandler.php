<?php

declare(strict_types=1);

namespace framework\database;

use framework\config\DbConfig;
use framework\interfaces\DbConnectionInterface;
use framework\interfaces\DbHandlerInterface;
use framework\interfaces\DbStatementInterface;

/**
 * @author Therion86
 */
class DbHandler implements DbHandlerInterface
{

    /**
     * @var DbConnectionInterface|null
     */
    private ?DbConnectionInterface $dbConnection;

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
     * @return DbConnectionInterface
     * @author Therion86
     */
    public function getConnection(): DbConnectionInterface
    {
        if (null === $this->dbConnection) {
            return $this->dbConnection = new DbConnection($this->dsn, $this->user, $this->password);
        }
        return $this->dbConnection;
    }

    /**
     * @param string $statement
     * @return DbStatementInterface
     * @author Therion86
     */
    public function prepareStatement(string $statement): DbStatementInterface
    {
        return $this->getConnection()->prepareStatement($statement, []);
    }
}