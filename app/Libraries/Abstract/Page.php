<?php

namespace App\Libraries\Abstract;

use App\Libraries\Theme;

class Page 
{
    protected ?string $routePath = null;
    protected ?string $view = null;
    public ?bool $isEdit = false;

    function __construct(protected $resource)
    {
    }

    public function getRoute()
    {
        return $this->routePath;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function render($id = null)
    {
        return Theme::render($this->view, [
            'resource' => $this->resource,
            'page' => $this
        ]);
    }
}