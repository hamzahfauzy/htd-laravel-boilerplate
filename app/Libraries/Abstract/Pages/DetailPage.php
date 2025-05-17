<?php

namespace App\Libraries\Abstract\Pages;

use App\Libraries\Abstract\Page;
use App\Libraries\Theme;

class DetailPage extends Page
{
    /**
     * @var view-string
     */
    protected ?string $view = 'pages.detail';
    protected ?string $routePath = '{id}';

    public function render($id = null)
    {
        $data = $this->resource::getModel()->find($id);
        
        $this->resource::setRecord($data);
        
        $header = $this->resource::detailHeader();
        $fields = $this->resource::detail();


        return Theme::render($this->view, [
            'resource' => $this->resource,
            'page' => $this,
            'header' => $header,
            'data' => $data,
            'fields' => $fields,
        ]);
    }
}