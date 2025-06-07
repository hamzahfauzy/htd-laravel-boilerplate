<?php

namespace App\Libraries;

class NavPanel {

    private static $items = [];

    static function add($item)
    {
        static::$items[] = $item;
    }

    static function get()
    {
        return array_filter(static::$items, function ($item) {
            // Jika ada 'can' => closure, evaluasi di sini
            if (isset($item['can']) && is_callable($item['can'])) {
                return call_user_func($item['can']);
            }

            return true;
        });
    }

}