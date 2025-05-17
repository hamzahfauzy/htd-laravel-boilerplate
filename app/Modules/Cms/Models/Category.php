<?php

namespace App\Modules\Cms\Models;

use App\Modules\Base\Traits\HasCreator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasCreator;

    protected $table = 'base_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'created_by'
    ];

    public function categorizables()
    {
        return $this->hasMany(Categorizable::class);
    }
    
}
