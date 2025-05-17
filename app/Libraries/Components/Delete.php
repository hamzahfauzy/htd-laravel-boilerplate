<?php

namespace App\Libraries\Components;

class Delete {

    private $authorized = true;

    function __construct(private $args)
    {
    }

    function routeName($name)
    {
        $this->authorized = auth()->user()->canAccess($name);
        return $this;
    }

    function render()
    {
        if(!$this->authorized) return '';
        $args = $this->args;

        return view('libraries.components.delete', [
            'attr' => $args
        ])->render();
    }
}