<?php

namespace App\Libraries\Components;

class Button {

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
        if($args['url'])
        {
            return view('libraries.components.link', [
                'attr' => $args
            ])->render();
        }

        return view('libraries.components.button', [
            'attr' => $args
        ])->render();
    }
}