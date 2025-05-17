<?php

namespace App\Modules\Cms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Postable extends Model
{
    use HasFactory;

    protected $table = 'base_postables';

    public function entity()
    {
        return $this->morphTo();
    }
}
