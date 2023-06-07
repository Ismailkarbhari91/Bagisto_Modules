# Go to packages/Webkul/Admin/src/DataGrids

# Replace Product Column code with below code

 $this->addColumn([
            'index'      => 'product_name',
            'label'      => trans('admin::app.datagrid.name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => true,
            'closure'    => function ($row) {
                if (! empty($row->url_key)) {
                    return "<a href='" .'http://151.80.237.29:34055/product/specific/'. $row->url_key . "' target='_blank'>" . $row->product_name . "</a>";
                }
                return $row->product_name;
            },
        ]);

# Replace href url with your url.
