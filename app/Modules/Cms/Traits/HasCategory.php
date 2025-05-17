<?php

namespace App\Modules\Cms\Traits;

use App\Modules\Cms\Models\Category;

trait HasCategory {

    public function categories()
    {
        return $this->morphToMany(Category::class, 'entity', 'base_categorizables', null, 'category_id');
    }

}