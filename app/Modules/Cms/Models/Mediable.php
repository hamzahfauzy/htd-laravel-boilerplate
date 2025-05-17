<?php

namespace App\Modules\Cms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mediable extends Model
{
    use HasFactory;

    protected $table = 'base_mediables';

    public function entity()
    {
        return $this->morphTo();
    }
}
