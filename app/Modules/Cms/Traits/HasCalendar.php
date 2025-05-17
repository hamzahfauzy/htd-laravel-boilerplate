<?php

namespace App\Modules\Cms\Traits;

use App\Modules\Cms\Models\Calendar;

trait HasCalendar 
{
    
    public function calendar()
    {
        return $this->morphOne(Calendar::class, 'entity');
    }
}