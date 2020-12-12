<?php

declare(strict_types=1);

namespace framework\interfaces;

use framework\exceptions\DbStatementException;

/**
 * @author Therion86
 */
interface DbStatementInterface
{

    /**
     * @return array
     * @author Therion86
     */
    public function fetchAllAssoc(): array;

    /**
     * @return string
     * @author Therion86
     */
    public function getSql(): string;

    /**
     * @param array $array
     * @param string $paramName
     * @param int $dataType
     * @return void
     * @throws DbStatementException
     * @author Theiron86
     */
    public function bindArray(array $array, string $paramName, int $dataType): void;

    /**
     * @param array|null $input_parameters
     * @return bool
     * @author Therion86
     */
    public function execute(?array $input_parameters = null): bool;
}