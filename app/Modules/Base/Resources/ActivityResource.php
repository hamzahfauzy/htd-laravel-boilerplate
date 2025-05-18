<?php

namespace App\Modules\Base\Resources;

use App\Libraries\Abstract\Resource;
use App\Libraries\Components\Button;
use App\Modules\Base\Models\Activity;

class ActivityResource extends Resource
{

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
            ],
            '_action'
        ];
    }

    public static function getPages()
    {
        $resource = static::class;
        return [
            'index' => new \App\Libraries\Abstract\Pages\ListPage($resource),
            'detail' => new \App\Libraries\Abstract\Pages\DetailPage($resource),
        ];
    }

    public static function getAction($d)
    {
        $buttons = [
            'view' => (new Button([
                'url' => static::getPageRoute('detail', ['id' => $d->id]),
                'label' => 'Detail',
                'class' => 'dropdown-item',
                'icon' => 'fas fa-fw fa-eye'
            ]))
                ->routeName(static::getPageRouteName('detail'))
                ->render()
        ];

        return view('libraries.components.actions', compact('buttons'))->render();
    }

    public static function detail()
    {
        return [
            'Basic Information' => [
                'creator.name' => 'User',
                'action' => 'Action',
                'data' => 'Data',
                'description' => 'Description',
                'created_at' => 'Created At'
            ]
        ];
    }

    public static function listHeader()
    {
        return [
            'title' => static::$navigationLabel . ' List',
            'button' => []
        ];
    }

    public static function detailHeader()
    {
        return [
            'title' => static::$navigationLabel . ' Detail',
            'button' => [
                (new Button([
                    'url' => static::getPageRoute('index'),
                    'class' => 'btn btn-sm btn-outline-secondary',
                    'label' => 'Back',
                    'icon' => 'fas fa-fw fa-arrow-left'
                ]))
                    ->routeName(static::getPageRouteName('index'))
                    ->render()
            ]
        ];
    }
}
