<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Str;

trait HasDotNotationFilter
{
    /**
     * Apply where clause with dot notation support (e.g. profile.code or invoice.customer.name).
     */
    public function scopeWhereDot(Builder $query, string $field, string $operator = '=', $value = null): Builder
    {
        if (str_contains($field, '.')) {
            $parts = explode('.', $field);
            $column = array_pop($parts); // last segment is column
            $relationPath = implode('.', $parts); // invoice.customer (possibly nested)

            // If the model has the top-level relation method, assume nested relations exist and use whereHas
            $firstRelation = $parts[0] ?? null;

            if ($firstRelation && method_exists($query->getModel(), $firstRelation)) {
                // use whereHas with the full dotted relation path and apply where on the related query
                return $query->whereHas($relationPath, function ($q) use ($column, $operator, $value) {
                    $q->where($column, $operator, $value);
                });
            } else {
                // Treat as joined table column like customers.name
                // Try to resolve table name from relation method if exists (safer), else pluralize first segment
                $table = $parts[0] ?? null;

                if ($table && method_exists($query->getModel(), $table)) {
                    try {
                        $relationObj = $query->getModel()->{$table}();
                        if ($relationObj instanceof Relation) {
                            $relatedModel = $relationObj->getRelated();
                            $table = $relatedModel->getTable();
                        } else {
                            // fallback to plural if relation method doesn't return Relation
                            $table = Str::plural($table);
                        }
                    } catch (\Throwable $e) {
                        $table = Str::plural($table);
                    }
                } elseif ($table) {
                    $table = Str::plural($table);
                }

                return $query->where("{$table}.{$column}", $operator, $value);
            }
        }

        return $query->where($field, $operator, $value);
    }

    /**
     * Apply OR where clause with dot notation support.
     */
    public function scopeOrWhereDot(Builder $query, string $field, string $operator = '=', $value = null): Builder
    {
        if (str_contains($field, '.')) {
            $parts = explode('.', $field);
            $column = array_pop($parts);
            $relationPath = implode('.', $parts);
            $firstRelation = $parts[0] ?? null;

            if ($firstRelation && method_exists($query->getModel(), $firstRelation)) {
                return $query->orWhereHas($relationPath, function ($q) use ($column, $operator, $value) {
                    $q->where($column, $operator, $value);
                });
            } else {
                $table = $parts[0] ?? null;

                if ($table && method_exists($query->getModel(), $table)) {
                    try {
                        $relationObj = $query->getModel()->{$table}();
                        if ($relationObj instanceof Relation) {
                            $relatedModel = $relationObj->getRelated();
                            $table = $relatedModel->getTable();
                        } else {
                            $table = Str::plural($table);
                        }
                    } catch (\Throwable $e) {
                        $table = Str::plural($table);
                    }
                } elseif ($table) {
                    $table = Str::plural($table);
                }

                return $query->orWhere("{$table}.{$column}", $operator, $value);
            }
        }

        return $query->orWhere($field, $operator, $value);
    }

    /**
     * Apply multiple filters from array.
     * Example: ['name' => 'John', 'profile.code' => 'LIKE:%123%']
     */
    public function scopeFilterDots(Builder $query, array $filters): Builder
    {
        foreach ($filters as $field => $condition) {
            if (is_string($condition) && str_starts_with($condition, 'LIKE:')) {
                $value = substr($condition, 5);
                $query->whereDot($field, 'LIKE', $value);
            } else {
                $query->whereDot($field, '=', $condition);
            }
        }

        return $query;
    }
}