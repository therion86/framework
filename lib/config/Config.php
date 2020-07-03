<?php

declare(strict_types=1);

namespace framework\config;

/**
 * @author Therion86
 */
class Config
{

    private DbConfig $dbConfig;

    private string $configFile;

    /**
     * @param string $configFile
     * @author Therion86
     */
    public function __construct(string $configFile)
    {
        $this->configFile = $configFile;
    }

    /**
     * @return void
     * @author Therion86
     */
    public function init(): void
    {
        $file = file_get_contents($this->configFile);
        $config = json_decode($file);
        $this->dbConfig = new DbConfig(
            $config->database->dbDsn,
            $config->database->dbUser,
            $config->database->dbPassword
        );
    }

    /**
     * @return DbConfig
     * @author Therion86
     */
    public function getDbConfig(): DbConfig
    {
        if (null === $this->dbConfig) {
            $this->init();
        }
        return $this->dbConfig;
    }
}