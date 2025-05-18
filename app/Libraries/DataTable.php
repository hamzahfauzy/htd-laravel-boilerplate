<?php

namespace App\Libraries;

use App\Libraries\Components\Action;
use Illuminate\Support\Arr;

class DataTable 
{
    function __construct(private $model, private $fields, private $resource = null)
    {
    }

    public function renderColumn($class = 'datatable')
    {
        $fields = $this->fields;
        $columns = ['No.'];
        foreach($fields as $field => $attr)
        {
            if((is_array($attr) && in_array($field, ['_action'])) || $attr == '_action')
            {
                $columns[] = __('Actions');
            }
            else
            {
                $columns[] = is_array($attr) && isset($attr['label']) ? $attr['label'] : (is_array($attr) && !isset($attr['label']) ? $field : $attr);
            }
        }
        return view('libraries.datatable.table', compact('columns', 'class'))->render();
    }

    public function response()
    {
        if(!isset($_GET['draw']))
        {
            return [];
        }

        $model = $this->model;
        $fields = $this->fields;
        $draw    = request('draw', 1);
        $start   = request('start', 0);
        $length  = request('length', 20);
        $order   = request('order', [['column' => 1,'dir' => 'asc']]);
        $filter  = request('search', [
            'value' => ''
        ]);

        $columns = [];
        $search_columns = [];
        $order_columns = [];
        foreach($fields as $key => $field)
        {
            $column = is_array($field) || is_callable($field) ? $key : $field;
            if(is_array($field) && isset($field['_order']))
            {
                $order_columns[] = $field['_order'];
            }
            else
            {
                $order_columns[] = $column;
            }
            $columns[] = $column;
            $keyField = is_array($field) ? $key : $field;
            if(
                (is_array($field) && isset($field['_searchable']) && !$field['_searchable']) || 
                (is_array($field) && !isset($field['_searchable'])) ||
                ($keyField == '_action')
            ) continue;

            $keyField = is_string($field['_searchable']) || is_array($field['_searchable']) ? $field['_searchable'] : $keyField;
            if(is_array($keyField))
            {
                $search_columns = array_merge($search_columns, $keyField);
            }
            else
            {
                $search_columns[] = $keyField;
            }
        }

        if(count($search_columns))
        {
            $model = $model->when($filter['value'] ?? false, function ($q, $search) use ($search_columns) {
                if(!empty($search))
                {
                    foreach($search_columns as $index => $column)
                    {
                        if($index == 0)
                        {
                            if(strpos($column, '.') > -1)
                            {
                                $q->whereDot($column, 'LIKE', "%$search%");
                            }
                            else
                            {
                                $q->where($column, 'LIKE', "%$search%");
                            }
                        }
                        else
                        {
                            if(strpos($column, '.') > -1)
                            {
                                $q->orWhereDot($column, 'LIKE', "%$search%");
                            }
                            else
                            {
                                $q->orWhere($column, 'LIKE', "%$search%");
                            }
                        }

                    }
                }
            });
        }

        if($order[0]['column'] > 0)
        {
            $col_order = $order[0]['column']-1;
            $col_order = $col_order < 0 ? 'id' : $order_columns[$col_order];
    
            if($col_order)
            {
                $model = $model->orderBy($col_order, $order[0]['dir']);
            }
        }

        $total = $model->count();
        $data = $model->offset($start)->limit($length)->get();
        $results = $data->map(function($d, $index) use ($fields, $start){
            $final = [$start+$index+1];
            foreach($fields as $field => $value)
            {
                if($field == '_action' || $value == '_action')
                {
                    // default action
                    $final[] = Action::render($this->resource, $d);
                }

                if(is_array($value)){
                    $final[] = Utility::arrGet($d, $field, '');
                }
                else if(is_callable($value))
                {
                    $final[] = $value($d)['value'];
                }
                else
                {
                    $final[] = Utility::arrGet($d, $value, '');
                }
            }
            
            return $final;
        });

        return [
            "draw" => $draw,
            "recordsTotal" => (int) $total,
            "recordsFiltered" => (int) $total,
            "data" => $results->all()
        ];
    }
}