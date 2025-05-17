<?php

namespace App\Modules\Cms\Traits;

use App\Modules\Cms\Models\Media;

trait HasMedia {

    public function mediable()
    {
        return $this->morphToMany(Media::class, 'base_mediables');
    }

    public function media()
    {
        return $this->mediable->last();
    }

}