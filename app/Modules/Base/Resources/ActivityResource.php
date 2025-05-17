<?php

namespace App\Modules\Base\Resources;

use App\Libraries\Abstract\Resource;
use App\Modules\Base\Models\Activity;

class ActivityResource extends Resource {

    protected static ?string $navigationGroup = 'Base';
    protected static ?string $navigationLabel = 'Activity';
    protected static ?string $navigationIcon = 'bx bx-stopwatch';
    protected static ?string $slug = 'activities';
    protected static ?string $routeGroup = 'base';

    protected static $model = Activity::class;

    public static function table()
    {
        return [
            'creator.name' => [
                'label' => 'User'
            ],
            'action' => [
                'label' => 'Action',
                '_searchable' => true
            ],
            'description' => [
                'label' => 'Description',
                '_searchable' => true
            ],
            // 'data' => [
            //     'label' => 'Data',
            // ],
            'created_at' => [
                'label' => 'Created At'
            ]
        ];
    }

    public static function listHeader()
    {
        return [
            'title' => static::$navigationLabel . ' List',
            'button' => [
            ]
        ];
    }
}