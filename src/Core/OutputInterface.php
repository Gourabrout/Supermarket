<?php

namespace Supermarket\Core;

interface OutputInterface
{
    /**
     * print function
     *
     * @param mixed $message
     * @return string
     */
    public function print($message);
}
