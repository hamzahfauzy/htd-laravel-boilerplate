<?php

namespace App\Libraries;

class Menu
{
    static function get()
    {
        $menu = config('menu', []);
        foreach($menu as $key => $m)
        {
            usort($m, function($a, $b) {
                return strcmp($a::getNavigationOrder(), $b::getNavigationOrder());
            });

            $menu[$key] = $m;
        }
        // dd($menu);

        return $menu;
    }
}