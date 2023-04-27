<?php

declare(strict_types=1);


namespace Therion86\Framework\Cli;

class CliFunctions
{

    public function writeLn(string $text)
    {
        echo $text . PHP_EOL;
    }

    public function write(string $text)
    {
        echo $text;
    }
}