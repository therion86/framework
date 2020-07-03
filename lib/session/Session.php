<?php

namespace framework\session;

use framework\user\User;

/**
 * @author Therion86
 */
class Session
{

    /**
     * @author Therion86
     */
    public function __construct()
    {
    }

    /**
     * @param mixed $value
     * @param string $key
     * @author Therion86
     */
    public function add(
        string $key,
        $value
    ): void {
        $_SESSION[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed|null
     * @author Therion86
     */
    public function get(string $key)
    {
        if (!$this->keyExist($key)) {
            return null;
        }
        return $_SESSION[$key];
    }

    /**
     * @param string $key
     * @return bool
     * @author Therion86
     */
    public function keyExist(string $key): bool
    {
        if (isset($_SESSION[$key])) {
            return true;
        }
        return false;
    }

    /**
     * @return User|null
     * @author Therion86
     */
    public function getUser(): ?User
    {
        if (!$this->keyExist('framework.user')) {
            return null;
        }
        return $this->get('framework.user');
    }

    /**
     * @param User $user
     * @return void
     * @author Therion86
     */
    public function addUser(User $user): void
    {
        $this->add('framework.user', $user);
    }

    /**
     * @return void
     * @author Therion86
     */
    public function logout(): void
    {
        session_destroy();
        $_SESSION = array();
    }
}