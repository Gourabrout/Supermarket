<?php

namespace Supermarket\Services;

use Supermarket\Core\OutputInterface;

class OutputService implements OutputInterface
{
    /**
     * print function
     *
     * @param mixed $message
     * @return string
     */
    public function print($message) {
        echo $message . PHP_EOL;
    }
}
