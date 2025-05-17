<?php

namespace App\Modules\Cms\Traits;

use App\Modules\Cms\Models\Post;

trait HasPost 
{
    
    public function posts()
    {
        return $this->morphToMany(Post::class, 'base_postables');
    }

    public function post()
    {
        return $this->posts->last();
    }
    
}