<?php

namespace App\Libraries;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class Utility {
    /**
     * Ambil nilai dari array atau model dengan memperhatikan
     * serializedDate di model.
     *
     * @param  array|Model  $target
     * @param  string|int  $key
     * @param  mixed  $default
     * @return mixed
     */
    static function arrGet($target, $key, $default = null)
    {
        if ($target instanceof Model) {
            // Auto-load relasi pertama jika belum dimuat
            $segments = explode('.', $key);
            if (count($segments) > 1) {
                $relation = $segments[0];
                if (! $target->relationLoaded($relation)) {
                    $target->load($relation); // lazy load relasi
                }
            }

            // Serialize dan ambil data
            return data_get($target->toArray(), $key, $default);
        }

        // Kalau bukan model, fallback ke Arr::get
        return data_get($target, $key, $default);
    }
}