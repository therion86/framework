<?php

declare(strict_types=1);

namespace framework\lib;

use framework\lib\database\DbHandler;
use framework\lib\request\Request;
use framework\lib\routing\RouteContainer;
use framework\src\ModuleRegisterer;

class DependencyInjection
{

    private ?Request $request;
    private RouteContainer $registeredRoutes;
    private ?DbHandler $dbHandler;

    public function __construct()
    {
        $this->registeredRoutes = new RouteContainer();
    }

    public function getRequest(): Request
    {
        return $this->request ?? new Request();
    }

    public function getRegisteredRoutes(): RouteContainer
    {
        return $this->registeredRoutes;
    }

    public function registerModules()
    {
        $moduleRegisterer = new ModuleRegisterer($this);
        $moduleRegisterer->registerModules();
    }

    public function getDatabaseHandler(): DbHandler
    {
        if (null !== $this->dbHandler) {
            return $this->dbHandler;
        }
        $config = json_decode(file_get_contents(__DIR__ . '/../dbConfig.json'), true);
        return $this->dbHandler = new DbHandler($config['dsn'], $config['user'], $config['password']);
    }
}