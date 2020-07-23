<?php

declare(strict_types=1);

namespace framework\database;

use framework\interfaces\DbStatementInterface;
use PDOStatement;
use framework\exceptions\DbStatementException;

/**
 * @author Therion86
 */
class DbStatement extends PDOStatement implements DbStatementInterface
{

    public const FETCH_ASSOC = 2;

    public const PARAM_INT = 1;
    public const PARAM_STR = 2;

    /**
     * @var DbConnection
     */
    private DbConnection $dbConnection;

    /**
     * @param $dbConnection
     * @author Therion86
     */
    protected function __construct($dbConnection)
    {
        $this->dbConnection = $dbConnection;
    }

    /**
     * @return array
     * @author Therion86
     */
    public function fetchAllAssoc(): array
    {
        return $this->fetchAll(self::FETCH_ASSOC);
    }

    /**
     * @return string
     * @author Therion86
     */
    public function getSql(): string
    {
        return $this->queryString;
    }

    /**
     * @param array $array
     * @param string $paramName
     * @param int $dataType
     * @return void
     * @throws DbStatementException
     * @author Theiron86
     */
    public function bindArray(array $array, string $paramName, int $dataType = self::PARAM_STR): void
    {
        if (!stristr($this->queryString, $paramName)) {
            throw DbStatementException::paramNotFound($paramName);
        }
        $newParams = [];
        $key = 0;
        foreach ($array as $value) {
            $currentNewParam = $paramName . $key;
            $this->bindValue($currentNewParam, $value, $dataType);
            $newParams[] = $currentNewParam;
            ++$key;
        }
        $this->queryString = str_replace($paramName, implode(',', $newParams), $this->queryString);
    }
}