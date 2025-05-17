<?php

namespace App\Modules\Base\Resources;

use App\Libraries\Abstract\Resource;
use App\Modules\Base\Models\Role;
use Illuminate\Http\Request;

class RoleResource extends Resource {

    protected static ?string $navigationGroup = 'Base';
    protected static ?string $navigationLabel = 'Roles';
    protected static ?string $navigationIcon = 'bx bx-slider';
    protected static ?string $slug = 'roles';
    protected static ?string $routeGroup = 'base';

    protected static $model = Role::class;

    public static function table()
    {
        return [
            'name' => [
                'label' => 'Name',
                '_searchable' => true
            ],
            '_action'
        ];
    }

    public static function form()
    {
        $groupedRoutes = [];
        $routes = \Illuminate\Support\Facades\Route::getRoutes();

        foreach($routes as $route)
        {
            $name = $route->getName();
            if (!$name) continue;
            $parts = explode('.', $name);
            if (count($parts) < 3) continue;

            [$prefix, $resource, $action] = $parts;

            $groupedRoutes[$resource][$action] = $name;
        }

        return [
            'Role Data' => [
                'name' => [
                    'label' => 'Name',
                    'type' => 'text',
                    'placeholder' => 'Enter role name',
                    'required' => true,
                ]
            ],
            'Feature Data' => [
                'routeNames' => [
                    'label' => 'Feature',
                    'type' => 'group-checkbox',
                    'options' => $groupedRoutes,
                    'required' => true,
                ]
            ]
        ];
    }

    public static function afterCreate(Request $request, $data)
    {
        $routes = request('routeNames');
        if(!empty($routes))
        {
            $routes = array_map(function($route) use ($data){
                return [
                    'role_id' => $data->id,
                    'route_name' => $route,
                    'created_by' => auth()->id()
                ];
            }, $routes);
    
            $data->routes()->insert($routes);
        }
    }
    
    public static function afterUpdate(Request $request, $data)
    {
        $data->routes()->delete();

        $routes = request('routeNames');
        if(!empty($routes))
        {
            $routes = array_map(function($route) use ($data){
                return [
                    'role_id' => $data->id,
                    'route_name' => $route,
                    'created_by' => auth()->id()
                ];
            }, $routes);
    
            $data->routes()->insert($routes);
        }
    }
    
    public static function detail()
    {
        return [
            'Role Data' => [
                'name' => 'Name'
            ],
            'Feature Data' => [
                'featureNames' => 'Feature'
            ]
        ];
    }

}