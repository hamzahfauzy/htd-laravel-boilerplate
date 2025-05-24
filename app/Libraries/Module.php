<?php

namespace App\Libraries;
use Illuminate\Support\Facades\File;

class Module
{
    private static $file = 'app/modules.json';

    static function read()
    {
        $modules = file_get_contents(storage_path(self::$file));
        return json_decode($modules, true);
    }

    static function write($modules)
    {
        file_put_contents(storage_path(self::$file), json_encode($modules));
    }

    static function findModule($moduleName)
    {
        $modules = self::read();
        $selectedModule = [];
        $selectedIndex = -1;
        foreach($modules as $index => $module)
        {
            if($module['name'] == $moduleName)
            {
                $selectedModule = $module;
                $selectedIndex = $index;
                break;
            }
        }

        return compact('modules','selectedModule', 'selectedIndex');
    }

    static function enable($moduleName)
    {
        $find = self::findModule($moduleName);

        if($find['selectedIndex'] > -1)
        {
            $find['selectedModule']['enable'] = true;
            $find['modules'][$find['selectedIndex']] = $find['selectedModule'];
            self::write($find['modules']);

            return true;
        }
        else
        {
            if(is_dir(base_path('app/Modules/'.$moduleName)))
            {
                $find['modules'][] = [
                    'name' => $moduleName,
                    'enable' => true
                ];

                self::write($find['modules']);

                return true;
            }
        }

        return false;
    }
    
    static function disable($moduleName)
    {
        $find = self::findModule($moduleName);

        if($find['selectedIndex'] > -1)
        {
            $find['selectedModule']['enable'] = false;
            $find['modules'][$find['selectedIndex']] = $find['selectedModule'];
            self::write($find['modules']);

            return true;
        }

        return false;
    }

    static function getEnabled()
    {
        $modules = self::read();

        return array_filter($modules, function($module){
            return $module['enable'] == true;
        });
    }

    static function register()
    {
        $modules = Module::getEnabled();
        $menu_group = explode(',', config('app.menu_group', '')) ?? [];
        $groupedMenu = [];
        $navShortcut = [];
        foreach($menu_group as $menu)
        {
            $groupedMenu[$menu] = [];
        }
        
        foreach($modules as $module)
        {
            $providerClass = "App\\Modules\\{$module['name']}\\Providers\\{$module['name']}ServiceProvider";
            $resourceListFile = base_path("App/Modules/{$module['name']}/Config/resources.php");
            
            if (class_exists($providerClass)) {
                app()->register($providerClass);
            }

            if(file_exists($resourceListFile))
            {
                $resourceLists = require $resourceListFile;
                foreach($resourceLists as $resource)
                {
                    $resource = new $resource;
                    $resource->registerRoutes();
                    $navShortcut = array_merge($navShortcut, $resource->getNavShortcut());
                    $group = $resource->getNavigationGroup();

                    if (!isset($groupedMenu[$group])) 
                    {
                        $groupedMenu[$group] = [];
                    }

                    $groupedMenu[$group][] = $resource;
                }
            }
        }
        
        config([
            'menu' => $groupedMenu,
            'nav_shortcut' => $navShortcut
        ]);
    }
}