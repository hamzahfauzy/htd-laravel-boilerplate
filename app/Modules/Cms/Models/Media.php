<?php

namespace App\Modules\Cms\Models;

use App\Modules\Base\Traits\HasCreator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory, SoftDeletes, HasCreator;

    protected $table = 'base_media';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'filename',
        'mime_type',
        'size',
        'metadata',
        'created_by'
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'metadata'      => 'object',
    ];

    public function mediables()
    {
        return $this->hasMany(Mediable::class);
    }

}
