<?php

namespace App\Modules\Base\Traits;

use App\Modules\Base\Models\Activity;

trait HasActivity {

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootHasActivity()
    {
        // auto-sets values on creation
        if(auth()->user())
        {
            static::created(function ($model){
                Activity::create([
                    'action' => $model::class . ' Created',
                    'description' => 'Data has been created with id ' .  $model->id,
                    'data' => $model
                ]);
            });
            
            static::updated(function ($model){
                Activity::create([
                    'action' => $model::class . ' Updated',
                    'description' => 'Data has been updated with id ' .  $model->id,
                    'data' => $model
                ]);
            });
            
            static::deleted(function ($model){
                Activity::create([
                    'action' => $model::class . ' Deleted',
                    'description' => 'Data has been deleted with id ' . $model->id,
                    'data' => $model
                ]);
            });

        }
    }
}