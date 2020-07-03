<?php

declare(strict_types=1);

namespace framework;

use framework\config\Config;
use framework\database\DbHandler;
use framework\interfaces\TemplateEngineInterface;
use framework\session\Session;
use framework\templateEngine\TemplateEngine;

/**
 * @author Therion86
 */
class DependencyInjection
{

    /**
     * @var DbHandler
     */
    private DbHandler $dbHandler;

    /**
     * @var Session
     */
    private Session $session;

    private Config $config;

    /**
     * @author Therion86
     */
    public function __construct(string $configFile)
    {
        $this->config = new Config($configFile);
        $this->config->init();
        $this->dbHandler = new DbHandler($this->config->getDbConfig());
        if (isset($_SESSION['framework.session']) !== true) {
            $_SESSION['framework.session'] = true;
            $this->session = new Session();
        } else {
            $this->session = new Session();
        }
    }

    /**
     * @return Session
     * @author Therion86
     */
    public function getSession(): Session
    {
        return $this->session;
    }

    /**
     * @return DbHandler
     * @author Therion86
     */
    public function getDbHandler(): DbHandler
    {
        return $this->dbHandler;
    }

    /**
     * @return TemplateEngineInterface
     * @author Therion86
     */
    public function getTemplateEngine(): TemplateEngineInterface
    {
        return new TemplateEngine();
    }
}