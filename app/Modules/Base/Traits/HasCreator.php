<?php

namespace App\Modules\Base\Traits;

use App\Modules\Base\Models\User;

trait HasCreator {

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootHasCreator()
    {
        // auto-sets values on creation
        static::creating(function ($query) {
            $userId = $query->created_by ? $query->created_by : (auth()->user() ? auth()->id() : null);
            if($userId)
            {
                $query->created_by = $userId;
            }
        });
    }

    public function creator()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
    
}