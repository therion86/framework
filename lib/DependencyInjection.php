<?php

declare(strict_types=1);

namespace framework;

use framework\config\Config;
use framework\crudGenerator\CrudGenerator;
use framework\crudGenerator\CrudGeneratorTemplateEngine;
use framework\crudGenerator\CrudListRepository;
use framework\crudGenerator\ListGenerator;
use framework\database\DbHandler;
use framework\formGenerator\FormGenerator;
use framework\interfaces\TemplateEngineInterface;
use framework\session\Session;
use framework\templateEngine\TemplateEngine;

/**
 * @author Therion86
 */
class DependencyInjection
{

    private DbHandler $dbHandler;

    private Session $session;

    /**
     * @param string $configFile
     * @author Therion86
     */
    public function __construct(string $configFile)
    {
        $config = new Config($configFile);
        $config->init();
        $this->dbHandler = new DbHandler($config->getDbConfig());

        if (isset($_SESSION['framework.session']) !== true) {
            $this->session = new Session();
            $_SESSION['framework.session'] = true;
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