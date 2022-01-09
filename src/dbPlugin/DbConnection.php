<?php

declare(strict_types=1);

namespace framework\src\dbPlugin;

use PDO;

class DbConnection
{

    private PDO $pdo;

    public function __construct(string $dsn, string $username, string $passwd)
    {
        $this->pdo = new PDO($dsn, $username, $passwd);
    }

    public function prepare(string $sql): DbStatement
    {
        return new DbStatement($this->pdo->prepare($sql));
    }

    public function executeQuery(string $sql)
    {
        return $this->pdo->exec($sql);
    }

    public function query(string $sql): DbStatement
    {
        return new DbStatement($this->pdo->query($sql));
    }
}