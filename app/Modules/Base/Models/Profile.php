<?php

namespace App\Modules\Base\Models;

use App\Modules\Base\Traits\HasCreator;
use App\Modules\Base\Traits\HasUser;
use App\Modules\Cms\Traits\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use HasFactory, SoftDeletes, HasUser, HasMedia, HasCreator;

    protected $table = 'base_profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'name',
        'address',
        'gender',
        'phone',
        'user_id',
        'metadata',
        'email',
        'record_type',
        'created_by'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'metadata'      => 'object',
    ];

}
