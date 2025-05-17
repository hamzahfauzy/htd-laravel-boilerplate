<?php

namespace App\Libraries;

class Theme {

    public static function render($path, $params = [])
    {
        $activeTheme = config('app.theme');
        $viewPath = 'themes.'. $activeTheme .'.'. $path;
        if(view()->exists($viewPath))
        {
            return view($viewPath,  $params);
        }

        return view('themes.default.'.$path, $params);
    }

}