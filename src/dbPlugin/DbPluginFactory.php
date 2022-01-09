<?php

namespace framework\src\dbPlugin;

class DbPluginFactory
{
    private $dbHandler;

    public function getDatabaseHandler(): DbHandler
    {
        if (null !== $this->dbHandler) {
            return $this->dbHandler;
        }
        $config = json_decode(file_get_contents(__DIR__ . '/dbConfig.json'), true, 512, JSON_THROW_ON_ERROR);
        return $this->dbHandler = new DbHandler($config['dsn'], $config['user'], $config['password']);
    }
}