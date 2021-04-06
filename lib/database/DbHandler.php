<?php
declare(strict_types=1);

namespace framework\lib\database;

class DbHandler {

	private ?DbConnection $dbConnection;

	private string $dsn;

	private string $user;

	private string $password;

	public function __construct(string $dsn, string $user, string $password) {
		$this->dsn = $dsn;
		$this->user = $user;
		$this->password = $password;
	}

	public function getConnection(): DbConnection {
		if (null === $this->dbConnection) {
			return $this->dbConnection = new DbConnection($this->dsn, $this->user, $this->password);
		}
		return $this->dbConnection;
	}

	public function prepareStatement(string $statement): DbStatement {
		return $this->getConnection()->prepare($statement);
	}
}