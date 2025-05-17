<?php

namespace App\Modules\Cms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorizable extends Model
{
    use HasFactory;

    protected $table = 'base_categorizables';

    public function entity()
    {
        return $this->morphTo();
    }
}
