<?php

namespace App\Modules\Cms\Traits;

use App\Modules\Cms\Models\Media;

trait HasMedia {

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootHasMedia()
    {
        // auto-sets values on creation
        static::created(function ($model) {
            if(isset($model->mediaField))
            {
                $media_id = request()->input($model->mediaField);
                if(isset($media_id) && !empty($media_id))
                {
                    $model->mediable()->sync([$media_id]);
                }
            }
        });
        
        static::updating(function ($model) {
            if(isset($model->mediaField))
            {
                $media_id = request()->input($model->mediaField);
                if(isset($media_id) && !empty($media_id))
                {
                    $model->mediable()->sync([$media_id => ['record_type' => $model->mediaField]]);
                }
            }
        });
    }

    public function mediable()
    {
        return $this->morphToMany(Media::class, 'entity', 'base_mediables', null, 'media_id')->withPivot('record_type');
    }

    public function media()
    {
        return $this->mediable->last();
    }

}