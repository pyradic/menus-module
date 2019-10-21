<?php

namespace Pyro\MenusModule\Ui;

use Illuminate\Support\Collection;

class ItemCollection extends Collection
{
    public function __construct(array $items = [])
    {
        parent::__construct($items);
    }

    /**
     * @return Item
     */
    public function active()
    {
        foreach ($this->items as $item) {
            if ($item->active) {
                return $item;
            }
        }
    }
}
