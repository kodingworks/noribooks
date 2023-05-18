<?php

namespace App\Helpers\Menu;

use Illuminate\Support\Facades\Auth;
use App\Interfaces\Menu\FilterInterface;


class ModuleAccess implements FilterInterface
{
    /**
     * Transforms a menu item. Add the restricted property to a menu item
     * when situable.
     *
     * @param  array  $item  A menu item
     * @return array The transformed menu item
     */
    public function transform($item)
    {
        // Set a special attribute when item is not allowed. Items with this
        // attribute will be filtered out of the menu.

        if (!$this->isEnabled($item)) {
            $item['restricted'] = true;
        }

        return $item;
    }

    /**
     * Check if a menu item is allowed for the current user.
     *
     * @param  array  $item  A menu item
     * @return bool
     */
    protected function isEnabled($item)
    {
        // Check if there are any permission defined for the item.
        if (empty($item['can'])) {
            return true;
        }

        if (is_array($item['can'])) {
            $return = [];
            foreach ($item['can'] as $key => $permission) {
                if (Auth::check() && !Auth::user()->can($permission)) {
                    $return[$key] = false;
                } else {
                    $return[$key] = true;
                }
            }

            if (in_array(true, $return)) {
                return true;
            } else {
                return false;
            }
        } else {
            if (Auth::check() && !Auth::user()->can($item['can'])
            ) {
                return false;
            }
        }

        return true;
    }
}
