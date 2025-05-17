<?php

namespace App\Modules\Base\Models;

use App\Modules\Base\Traits\HasActivity;
use App\Modules\Base\Traits\HasCreator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRoute extends Model
{
    use HasFactory, HasCreator, HasActivity;

    protected $table = 'base_role_routes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role_id',
        'route_name',
        'created_by'
    ];
}
