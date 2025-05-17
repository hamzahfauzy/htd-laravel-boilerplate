<?php

namespace App\Libraries\Components;

class Action
{
    static function getDefault($resource, $data)
    {
        $buttons = [
            'view' => (new Button([
                'url' => $resource::getPageRoute('detail', ['id' => $data->id]),
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