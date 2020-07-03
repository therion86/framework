<?php

declare(strict_types=1);

namespace framework\user;

/**
 * @author Therion86
 */
class User
{

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $login;

    /**
     * @param int $id
     * @param string $login
     * @author Therion86
     */
    public function __construct(int $id, string $login)
    {
        $this->id = $id;
        $this->login = $login;
    }

    /**
     * @return int
     * @author Therion86
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     * @author Therion86
     */
    public function getLogin(): string
    {
        return $this->login;
    }
}