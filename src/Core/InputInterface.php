<?php

namespace Supermarket\Core;

interface InputInterface
{
    /**
     * getItems function
     *
     * @return array
     */
    public function getItems();

    /**
     * getOrder function
     *
     * @return array
     */
    public function getOrder();
}
