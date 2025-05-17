<?php

namespace App\Modules\Base\Models;

use App\Modules\Base\Traits\HasActivity;
use App\Modules\Base\Traits\HasCreator;
use App\Traits\HasDotNotationFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, HasCreator, HasDotNotationFilter, HasActivity;

    protected $table = 'base_roles';
    protected $appends = ['routeNames','featureNames'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'created_by'
    ];

    public function getRouteNamesAttribute()
    {
        $routes = $this->routes->pluck('route_name')->toArray();

        return $routes;
    }

    public function getFeatureNamesAttribute()
    {
        $groupedRoutes = [];
        $routes = \Illuminate\Support\Facades\Route::getRoutes();
        $selectedRoutes = $this->routeNames;

        foreach($routes as $route)
        {
            $name = $route->getName();
            if (!$name) continue;
            $parts = explode('.', $name);
            if (count($parts) < 3) continue;

            [$prefix, $resource, $action] = $parts;
            if(in_array($name, $selectedRoutes))
            {
                $groupedRoutes[] = '<span class="badge bg-label-primary">'.$resource .'/'. $action.'</span>';
            }
        }

        return implode(' ', $groupedRoutes);
    }

    public function routes()
    {
        return $this->hasMany(RoleRoute::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'base_user_roles','role_id','user_id');
    }
}
