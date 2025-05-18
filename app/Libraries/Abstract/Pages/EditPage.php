<?php

namespace App\Libraries\Abstract\Pages;

use App\Libraries\Abstract\Page;
use App\Libraries\Theme;

class EditPage extends Page
{
    /**
     * @var view-string
     */
    protected ?string $view = 'pages.form';
    protected ?string $routePath = '{id}/edit';
    public ?bool $isEdit = true;

    public function render($id = null)
    {
        $this->resource::mount();
        $data = $this->resource::getModel()->find($id);
        $this->resource::setRecord($data);
        
        $header = $this->resource::editHeader();
        $sections = $this->resource::form();

        return Theme::render($this->view, [
            'resource' => $this->resource,
            'page' => $this,
            'sections' => $sections,
            'data' => $data,
            'header' => $header,
        ]);
    }
}