<?php

namespace App\Modules\Cms\Models;

use App\Modules\Base\Traits\HasCreator;
use App\Modules\Cms\Traits\HasCategory;
use App\Modules\Cms\Traits\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes, HasCreator, HasMedia, HasCategory;

    protected $table = 'base_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'content',
        'record_type',
        'visibility',
        'created_by'
    ];

    public function postables()
    {
        return $this->hasMany(Postable::class);
    }

}
