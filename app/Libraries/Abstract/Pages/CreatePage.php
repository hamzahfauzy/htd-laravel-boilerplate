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

        $this->resource::addScripts([
            'https://cdn.tiny.cloud/1/rsb9a1wqmvtlmij61ssaqj3ttq18xdwmyt7jg23sg1ion6kn/tinymce/7/tinymce.min.js'
        ]);

        $data = $this->resource::getRecord();

        return Theme::render($this->view, [
            'resource' => $this->resource,
            'page' => $this,
            'sections' => $sections,
            'data' => $data,
            'header' => $header,
        ]);
    }
}