<?php

declare(strict_types=1);

namespace framework\config;

/**
 * @author Therion86
 */
class DbConfig
{

    private string $dsn;

    private string $dbUser;

    private string $password;

    /**
     * @param string $dsn
     * @param string $dbUser
     * @param string $password
     * @author Therion86
     */
    public function __construct(string $dsn, string $dbUser, string $password)
    {
        $this->dsn = $dsn;
        $this->dbUser = $dbUser;
        $this->password = $password;
    }

    /**
     * @return string
     * @author Therion86
     */
    public function getDsn(): string
    {
        return $this->dsn;
    }

    /**
     * @return string
     * @author Therion86
     */
    public function getDbUser(): string
    {
        return $this->dbUser;
    }

    /**
     * @return string
     * @author Therion86
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}