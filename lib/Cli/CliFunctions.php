<?php

declare(strict_types=1);


namespace Therion86\Framework\Cli;

class CliFunctions
{
    private $stdout;
    private $stdin;

    private $stderr;

    public function __construct()
    {
        $this->stdout = fopen('php://stdout', 'wb');
        $this->stdin = fopen('php://stdin', 'rb');
        $this->stderr = fopen('php://stderr', 'wb');
    }


    public function writeLn(string $text, CliColor $color = CliColor::BLACK): void
    {
        fwrite($this->stdout, $color->value);

        fwrite($this->stdout, $text . PHP_EOL);

        fwrite($this->stdout, CliColor::BLACK->value);
    }

    public function write(string $text, CliColor $color = CliColor::BLACK): void
    {
        fwrite($this->stdout, $color->value);

        fwrite($this->stdout, $text);

        fwrite($this->stdout, CliColor::BLACK->value);
    }

    public function ln(): void
    {
        $this->write(PHP_EOL);
    }

    public function read($prompt, $color = CliColor::BLACK): string
    {
        $this->writeLn($prompt, $color);
        return trim(fgets($this->stdin));
    }

    public function error(string $error): void
    {
        fwrite($this->stderr, $error);
    }
}