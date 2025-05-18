<?php

namespace App\Libraries\Abstract\Pages;

use App\Libraries\Abstract\Page;
use App\Libraries\Theme;

class CreatePage extends Page
{
    /**
     * @var view-string
     */
    protected ?string $view = 'pages.form';
    protected ?string $routePath = 'create';
    public ?bool $isEdit = false;

    public function render($id = null)
    {
        $this->resource::mount();
        $header = $this->resource::createHeader();
        $sections = $this->resource::form();

        return Theme::render($this->view, [
            'resource' => $this->resource,
            'page' => $this,
            'sections' => $sections,
            'data' => [],
            'header' => $header,
        ]);
    }
}