<?php

namespace framework\interfaces;

/**
 * @author Therion86
 */
interface TemplateEngineInterface
{

    /**
     * @param string $paramName
     * @param mixed $value
     * @return void
     * @author Therion86
     */
    public function assign(string $paramName, $value): void;

    /**
     * @param string $templateName
     * @param string $module
     * @return void
     * @author Therion86
     */
    public function load(string $templateName, string $module): void;

    /**
     * @return string
     * @author Therion86
     */
    public function printTemplate(): string;
}