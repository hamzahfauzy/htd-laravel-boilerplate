<?php

namespace App\Modules\Base\Traits;

use App\Modules\Base\Models\User;

trait HasUser {

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
}