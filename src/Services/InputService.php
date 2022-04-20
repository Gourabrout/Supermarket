<?php

namespace Supermarket\Services;

use Supermarket\Core\InputInterface;

class InputService implements InputInterface
{
    private $itemsData = [];
    private $order;

    /**
     * getItems function
     *
     * @return array
     */
    public function getItems() {
        $count = (int) fgets(STDIN);
        for ($i = 0; $i < $count; $i++) {
            $this->itemsData[] = explode(' ', str_replace(PHP_EOL, '', fgets(STDIN)));
        }
        return $this->itemsData;
    }

    /**
     * getOrder function
     *
     * @return array
     */
    public function getOrder() {
        $this->order = explode(' ', str_replace(PHP_EOL, '', fgets(STDIN)));
        return $this->order;
    }
}
