<?php

namespace App\Modules\Cms\Resources;

use App\Libraries\Abstract\Resource;
use App\Modules\Cms\Models\Category;
use App\Modules\Cms\Models\Post;
use Illuminate\Http\Request;

class PostResource extends Resource {

    protected static ?string $navigationGroup = 'Cms';
    protected static ?string $navigationLabel = 'Post';
    protected static ?string $navigationIcon = 'bx bx-pencil';
    protected static ?string $slug = 'posts';
    protected static ?string $routeGroup = 'cms';

    protected static $model = Post::class;

    public static function table()
    {
        return [
            'title' => [
                'label' => 'Name',
                '_searchable' => true
            ],
            'visibility' => [
                'label' => 'Visibility',
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
        $categories = Category::pluck('name','id');
        return [
            'Post Form' => [
                'title' => [
                    'label' => 'Title',
                    'type' => 'text',
                    'placeholder' => 'Enter post title',
                    'required' => true,
                ],
                'content' => [
                    'label' => 'Content',
                    'type' => 'texteditor',
                    'placeholder' => 'Enter content',
                ],
                'categoryIds' => [
                    'label' => 'Category',
                    'type' => 'checkbox',
                    'options' => $categories,
                    'required' => true,
                ],
                'visibility' => [
                    'label' => 'Visibility',
                    'type' => 'select',
                    'placeholder' => 'Choose',
                    'options' => [
                        'DRAFT' => 'DRAFT',
                        'PUBLISH' => 'PUBLISH'
                    ],
                    'required' => true,
                ],
            ]
        ];
    }
    
    public static function beforeCreate(Request $request)
    {
        $request->merge([
            'slug' => \Str::slug($request->title)
        ]);
    }
    
    public static function afterCreate(Request $request, $data)
    {
        $data->categories()->sync($request->categoryIds);
    }
    
    public static function beforeUpdate(Request $request, $data)
    {
        $request->merge([
            'slug' => \Str::slug($request->title)
        ]);

        $data->categories()->sync($request->categoryIds);
    }
    
    public static function detail()
    {
        return [
            'Post Information' => [
                'slug' => 'Slug',
                'title' => 'Title',
                'visibility' => 'Visibility',
                'categoryList' => 'Category',
                'content' => 'Content',
            ],
        ];
    }

}