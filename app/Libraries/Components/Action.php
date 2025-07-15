<?php

namespace App\Libraries\Components;

use Illuminate\Support\Facades\Route;

class Action
{
    static function getDefault($resource, $data)
    {
        $detailPage = $resource::getPages()['detail'];
        $routePath = str_replace('{','',$detailPage->getRoute());
        $routePath = str_replace('}','',$routePath);
        $buttons = [
            'view' => (new Button([
                'url' => $resource::getPageRoute('detail', [$routePath => $data->{$routePath}]),
                'label' => 'Detail',
                'class' => 'dropdown-item',
                'icon' => 'fas fa-fw fa-eye'
            ]))
            ->routeName($resource::getPageRouteName('detail'))
            ->render(),
            'edit' => (new Button([
                'url' => $resource::getPageRoute('edit', ['id' => $data->id]),
                'label' => 'Edit',
                'class' => 'dropdown-item',
                'icon' => 'fas fa-fw fa-pencil'
            ]))
            ->routeName($resource::getPageRouteName('edit'))
            ->render(),
            'delete' => (new Delete([
                'url' => $resource::getPageRoute('delete', ['id' => $data->id]),
                'label' => 'Delete',
                'class' => 'dropdown-item text-danger delete-record',
                'icon' => 'fas fa-fw fa-trash'
            ]))
            ->routeName($resource::getPageRouteName('delete'))
            ->render()
        ];

        return $buttons;
    }

    static function render($resource, $data)
    {
        $buttons = static::getDefault($resource, $data);

        return view('libraries.components.actions', compact('buttons'))->render();
    }
}