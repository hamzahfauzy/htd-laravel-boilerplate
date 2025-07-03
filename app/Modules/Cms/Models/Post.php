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
    protected $mediaField = 'thumbnail';
    protected $appends = ['thumbnail'];

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

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function postables()
    {
        return $this->hasMany(Postable::class);
    }

    public function getCategoryListAttribute()
    {
        $categories = $this->categories->map(function($category){
           return $category->name; 
        });

        return implode(',', $categories->toArray());
    }
    
    public function getCategoryIdsAttribute()
    {
        $categories = $this->categories->pluck('id')->toArray();

        return $categories;
    }

    public function getThumbnailAttribute()
    {
        return $this->mediable()->wherePivot('record_type', $this->mediaField)->first();
    }

}
