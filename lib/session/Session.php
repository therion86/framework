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
        $sessionDir = BASE_PATH . '/session';
        if (false === is_dir($sessionDir)) {
            mkdir($sessionDir);
        }
        ini_set('session.save_path', $sessionDir);
        if (false === isset($_SESSION)) {
            session_start();
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @author Therion86
     */
    public function registerKey(
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
    public function getKey(string $key)
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
     * @return int|null
     * @author Therion86
     */
    public function getUserId(): ?int
    {
        if (false === $this->keyExist('framework.user.id')) {
            return null;
        }
        return (int)$this->getKey('framework.user.id');
    }

    /**
     * @param int $userId
     * @return void
     * @author Therion86
     */
    public function addUserId(int $userId): void
    {
        $this->registerKey('framework.user.id', $userId);
    }

    /**
     * @return void
     * @author Therion86
     */
    public function destroy(): void
    {
        session_destroy();
        $_SESSION = array();
    }
}