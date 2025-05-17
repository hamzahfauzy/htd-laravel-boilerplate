<?php

namespace App\Modules\Cms\Models;

use App\Modules\Cms\Traits\HasMedia;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory, HasMedia;

    protected $table = 'base_configs';

    public function entity()
    {
        return $this->morphTo();
    }
}
