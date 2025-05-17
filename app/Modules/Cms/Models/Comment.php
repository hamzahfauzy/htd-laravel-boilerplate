<?php

namespace App\Modules\Cms\Models;

use App\Modules\Base\Traits\HasCreator;
use App\Modules\Cms\Traits\HasMedia;
use App\Modules\Cms\Traits\HasPost;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes, HasCreator, HasMedia, HasPost;

    protected $table = 'base_comments';

    public function entity()
    {
        return $this->morphTo();
    }

}
