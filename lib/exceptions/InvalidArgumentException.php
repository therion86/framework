<?php

declare(strict_types=1);

namespace framework\interfaces;

class InvalidArgumentException extends \Exception
{

    /**
     * InvalidArgumentException constructor.
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}