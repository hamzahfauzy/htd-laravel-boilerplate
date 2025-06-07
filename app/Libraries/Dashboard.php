<?php

namespace App\Libraries;

class Dashboard
{
    private static $components = [];
    private static $welcomeScreen = null;

    static function add($component, $order = 0)
    {
        static::$components[$order][] = $component;
    }

    static function render()
    {
        $html = '';
        foreach(static::$components as $order => $components)
        {
            foreach($components as $component)
            {
                $html .= $component->render();
            }
        }

        return $html;
    }

    static function setWelcomeScreen($welcomeScreen)
    {
        static::$welcomeScreen = $welcomeScreen;
    }

    static function getWelcomeScreen()
    {
        return static::$welcomeScreen ?? Theme::render('welcome');
    }

}