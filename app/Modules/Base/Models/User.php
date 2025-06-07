<?php

namespace App\Modules\Base\Models;

use App\Modules\Base\Traits\HasActivity;
use App\Traits\HasDotNotationFilter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes, HasDotNotationFilter, HasActivity;

    protected $table = 'base_users';

    protected $appends = ['verifiedStatus','verifiedStatusBadge','roleNames','userRoleLabel'];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getVerifiedStatusAttribute()
    {
        return $this->email_verified_at ? 'Verified' : 'Not Verified';
    }
    
    public function getVerifiedStatusBadgeAttribute()
    {
        return '<span class="badge bg-label-'.($this->email_verified_at ? 'success' : 'danger').'">'.$this->verifiedStatus.'</span>';
    }

    public function getUserRoleLabelAttribute()
    {
        $roles = $this->roles;
        $labels = [];
        foreach($roles as $role)
        {
            $labels[] = '<span class="badge bg-label-primary">'.$role->name.'</span>';
        }

        return implode(' ', $labels);
    }
    
    public function getRoleNamesAttribute()
    {
        $roles = $this->roles->pluck('id')->toArray();

        return $roles;
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'base_user_roles', 'user_id', 'role_id');
    }

    public function canAccess(string $routeName)
    {
        $routes = $this->routes();
        $matches = array_filter($routes, function($pattern) use ($routeName) {
            return fnmatch($pattern, $routeName);
        });

        return !empty($matches);
    }

    public function routes()
    {
        return DB::table('base_role_routes')
            ->select('base_role_routes.route_name')
            ->join('base_roles', 'base_roles.id','=','base_role_routes.role_id')
            ->join('base_user_roles','base_user_roles.role_id','=','base_roles.id')
            ->where('base_user_roles.user_id', $this->id)
            ->get()
            ->pluck('route_name')->toArray()
        ;
    }

    public function getProfileImageUrl()
    {
        return $this->profile?->pic_url ? Storage::url($this->profile->pic_url) : asset('assets/img/avatars/1.png');
    }
}
