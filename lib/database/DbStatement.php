<?php
declare(strict_types=1);

namespace framework\lib\database;

use PDO;
use PDOStatement;

class DbStatement {

	private PDOStatement $pdoStatement;

	public function __construct(PDOStatement $pdoStatement) {
        $this->pdoStatement = $pdoStatement;
    }

	public function fetchAllAssoc(): array {
		return $this->pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
	}

    public function fetchColumn(?int $column = 0): mixed
    {
        return $this->pdoStatement->fetch(PDO::FETCH_COLUMN, $column);
	}

	public function getSql(): string {
		return $this->pdoStatement->queryString;
	}
}