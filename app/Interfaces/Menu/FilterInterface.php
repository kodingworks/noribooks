<?php

namespace App\Interfaces\Menu;

interface FilterInterface
{
    /**
     * Transforms a menu item in some way.
     *
     * @param  array  $item  A menu item
     * @return array The transformed menu item
     */
    public function transform($item);
}
