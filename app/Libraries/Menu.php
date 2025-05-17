<?php

namespace App\Libraries;

class Menu
{
    static function get()
    {
        return config('menu', []);
    }
}