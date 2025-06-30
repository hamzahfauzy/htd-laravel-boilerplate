<?php

namespace App\Modules\Cms\Resources;

use App\Libraries\Abstract\Resource;
use App\Modules\Cms\Models\Category;
use Illuminate\Http\Request;

class CategoryResource extends Resource {

    protected static ?string $navigationGroup = 'Cms';
    protected static ?string $navigationLabel = 'Categories';
    protected static ?string $navigationIcon = 'bx bx-box';
    protected static ?string $slug = 'categories';
    protected static ?string $routeGroup = 'cms';

    protected static $model = Category::class;

    public static function table()
    {
        return [
            'name' => [
                'label' => 'Name',
                '_searchable' => true
            ],
            'creator.name' => [
                'label' => 'Created By',
                '_searchable' => true
            ],
            'created_at' => [
                'label' => 'Created At',
                '_searchable' => true
            ],
            'updated_at' => [
                'label' => 'Updated At',
                '_searchable' => true
            ],
            '_action'
        ];
    }

    public static function form()
    {
        return [
            'Category Form' => [
                'name' => [
                    'label' => 'Name',
                    'type' => 'text',
                    'placeholder' => 'Enter category name',
                    'required' => true,
                ],
            ]
        ];
    }
    
    public static function beforeCreate(Request $request)
    {
        $request->merge([
            'slug' => \Str::slug($request->name)
        ]);
    }
    
    public static function beforeUpdate(Request $request, $data)
    {
        $request->merge([
            'slug' => \Str::slug($request->name)
        ]);
    }
    
    public static function detail()
    {
        return [
            'Category Information' => [
                'slug' => 'Slug',
                'name' => 'Name',
            ],
        ];
    }

}