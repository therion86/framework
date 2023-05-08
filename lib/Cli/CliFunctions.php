<?php

declare(strict_types=1);


namespace Therion86\Framework\Cli;

/**
 * @codeCoverageIgnore
 */
class CliFunctions
{
    private const ESCAPE = "\e[";
    private const RESET = "\e[0m";

    private $stdout;
    private $stdin;

    private $stderr;

    public function __construct()
    {
        $this->stdout = fopen('php://stdout', 'wb');
        $this->stdin = fopen('php://stdin', 'rb');
        $this->stderr = fopen('php://stderr', 'wb');
    }

    public function writeLn(string $text, CliFormatOptions ...$cliFormatOptions): void
    {
        fwrite($this->stdout, $this->formatText($text, ...$cliFormatOptions) . PHP_EOL);
    }

    private function formatText(string $text, CliFormatOptions ...$cliFormatOptions): string
    {
        $formats = array_map(static fn(CliFormatOptions $options) => $options->value, $cliFormatOptions);

        return self::ESCAPE . implode(';', $formats) . 'm' . $text . self::RESET;
    }

    public function write(string $text, CliFormatOptions ...$cliFormatOptions): void
    {
        fwrite($this->stdout, $this->formatText($text, ...$cliFormatOptions));

    }

    public function ln(): void
    {
        $this->write(PHP_EOL);
    }

    public function read($prompt, CliFormatOptions ...$cliFormatOptions): string
    {
        $this->writeLn($prompt, ...$cliFormatOptions);
        return trim(fgets($this->stdin));
    }

    public function error(string $error): void
    {
        fwrite($this->stderr, $error);
    }
}