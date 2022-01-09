<?php
declare(strict_types=1);

namespace framework\src\dbPlugin;

use PDO;
use PDOStatement;

class DbStatement {

	private PDOStatement $pdoStatement;

	public function __construct(PDOStatement $pdoStatement) {
        $this->pdoStatement = $pdoStatement;
    }

	public function fetchAllAssoc(): array {
        $this->pdoStatement->execute();
		return $this->pdoStatement->fetchAll(\PDO::FETCH_ASSOC);
	}

    public function fetchColumn(?int $column = 0): mixed
    {
        $this->pdoStatement->execute();
        return $this->pdoStatement->fetch(PDO::FETCH_COLUMN, $column);
	}

    public function fetchAllColumn(?int $column = 0): mixed
    {
        $this->pdoStatement->execute();
        return $this->pdoStatement->fetchAll(PDO::FETCH_COLUMN, $column);
    }

	public function getSql(): string {
		return $this->pdoStatement->queryString;
	}
}