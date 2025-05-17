<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasDotNotationFilter
{
    /**
     * Apply where clause with dot notation support (e.g. profile.code).
     */
    public function scopeWhereDot(Builder $query, string $field, string $operator = '=', $value = null): Builder
    {
        if (str_contains($field, '.')) {
            [$relation, $column] = explode('.', $field, 2);

            return $query->whereHas($relation, function ($q) use ($column, $operator, $value) {
                $q->where($column, $operator, $value);
            });
        }

        return $query->where($field, $operator, $value);
    }

    /**
     * Apply multiple filters from array.
     * Example: ['name' => 'John', 'profile.code' => 'LIKE:%123%']
     */
    public function scopeFilterDots(Builder $query, array $filters): Builder
    {
        foreach ($filters as $field => $condition) {
            if (str_starts_with($condition, 'LIKE:')) {
                $value = substr($condition, 5);
                $query->whereDot($field, 'LIKE', $value);
            } else {
                $query->whereDot($field, '=', $condition);
            }
        }

        return $query;
    }
}
