<?php

declare(strict_types=1);


namespace Therion86\Framework\Cli;

class Argument
{
    public function __construct(private array $args)
    {
        array_shift($this->args);
    }

    public function getMethod(): string|bool
    {
        return current($this->args);
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function hasArg(string $argument): bool
    {
        if (! str_contains($argument, '--')) {
            $argument = '--' . $argument;
        }
        foreach ($this->args as $arg) {
            if (str_contains($arg, $argument)) {
                return true;
            }
        }

        return false;
    }

    public function getArgValue(string $argument, $default = null)
    {
        if (! str_contains($argument, '--')) {
            $argument = '--' . $argument;
        }
        foreach ($this->args as $i => $value) {
            if ($value === $argument) {
                if (isset($this->args[$i + 1])) {
                    return $this->args[$i + 1];
                }
                break;
            }

            if (str_starts_with($value, $argument . '=')) {
                return substr($value, strlen($argument) + 1);
            }
        }

        return $default;
    }
}