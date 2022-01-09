<?php
declare(strict_types=1);

namespace framework\src\dbPlugin;

class DbHandler {

	private DbConnection $dbConnection;

    public function __construct(private string $dsn, private string $user, private string $password) {
        $this->dbConnection = new DbConnection($this->dsn, $this->user, $this->password);
	}

	public function getConnection(): DbConnection {
        return $this->dbConnection;
	}
}