<?php

namespace App\Modules\Cms\Models\Base;

use App\Modules\Cms\Models\Scopes\Base\PostScope;

class Post extends \App\Modules\Cms\Models\Post
{
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::addGlobalScope(new PostScope);

        // auto-sets values on creation
        static::creating(function ($query) {
            $query->record_type = 'POST';
        });
    }
}
