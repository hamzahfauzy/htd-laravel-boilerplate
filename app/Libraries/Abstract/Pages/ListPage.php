<?php

namespace App\Libraries\Abstract\Pages;

use App\Libraries\Abstract\Page;
use App\Libraries\DataTable;
use App\Libraries\Theme;

class ListPage extends Page
{
    /**
     * @var view-string
     */
    protected ?string $view = 'pages.list';
    protected ?string $routePath = '/';

    public function getTable()
    {
        return new DataTable($this->resource::getModel(), $this->resource::table(), $this->resource);
    }

    public function render($id = null)
    {
        $this->resource::mount();
        $datatable = $this->getTable();

        $response = $datatable->response();
        if($response)
        {
            return $response;
        }

        $header = $this->resource::listHeader();

        return Theme::render($this->view, [
            'resource' => $this->resource,
            'datatable' => $datatable,
            'page' => $this,
            'header' => $header,
        ]);
    }

}