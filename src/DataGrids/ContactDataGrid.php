<?php

namespace Webkul\Quote\DataGrids;

use Webkul\Ui\DataGrid\DataGrid;
use DB;


class ContactDataGrid extends DataGrid
{
    
    protected $index = 'quote_id'; //the column that needs to be treated as index column

    protected $sortOrder = 'desc'; //asc or desc

    protected $itemsPerPage = 50;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('quote')
                // ->join('countries','quote.country' ,'=', 'countries.code')
                ->join('product_flat','quote.pid','=','product_flat.id')
                ->addSelect('quote.id as quote_id', 'quote.name as name', 'quote.email as email','quote.phone as phone','quote.address as address','quote.quantity as quantity','product_flat.name as productname','quote.quotestatus as status','quote.created_at as date');



        $this->addFilter('quote_id', 'quote.id');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {
        $this->addColumn([
            'index' => 'quote_id',
            'label' => trans('quote_lang::app.datagrid.id'),
            'type' => 'number',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'name',
            'label' => trans('quote_lang::app.datagrid.name'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => false
        ]);

        $this->addColumn([
            'index' => 'email',
            'label' => trans('quote_lang::app.datagrid.email'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => false
        ]);

        $this->addColumn([
            'index' => 'productname',
            'label' => 'Product Name',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => false
        ]);

        $this->addColumn([
            'index' => 'quantity',
            'label' => 'Quantity',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => false
        ]);

        
        $this->addColumn([
            'index' => 'address',
            'label' => 'Address',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => false
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => 'Status',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => false
        ]);



        $this->addColumn([
            'index' => 'phone',
            'label' => 'number',
            'type' => 'number',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'date',
            'label' => 'date',
            'type' => 'date',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);
       

        // $this->addColumn([
        //     'index' => 'message_reply',
        //     'label' => trans('contact_lang::app.datagrid.message_reply'),
        //     'type' => 'string',
        //     'searchable' => false,
        //     'sortable' => false,
        //     'filterable' => false,

        //     'closure' => true,

        //     'wrapper' => function ($value) {
        //         if (strlen($value->message_reply) > 40)
        //             return substr($value->message_reply, 0,40).'...';
        //         else
        //             return $value->message_reply;
        //     }
        // ]);

        
    }

    public function prepareActions() {
        // $this->addAction([
        //     'type' => 'Edit',
        //     'method' => 'GET', // use GET request only for redirect purposes
        //     'route' => 'admin.agency.edit',
        //     'icon' => 'icon pencil-lg-icon',
        //     'title' => trans('contact_lang::app.agent.edit-help-title')
        // ]);


        // $this->addAction([
        //     'type' => 'View',
        //     'title'  => trans('admin::app.datagrid.edit'),
        //     'method' => 'GET',
        //     'route'  => 'admin.quote.statusquote',
        //     'icon'   => 'icon pencil-lg-icon',
        // ]);

        $this->addAction([
            'type' => 'View',
            'method' => 'GET', // use GET request only for redirect purposes
            'route' => 'admin.quote.view',
            'icon' => 'icon pencil-lg-icon',
            'title' => trans('quote_lang::app.contact.view')
        ]);




        $this->addAction([
            'type' => 'Delete',
            'method' => 'POST', // use GET request only for redirect purposes
            'route' => 'admin.quote.delete',
            'icon' => 'icon trash-icon',
            'title' => trans('quote_lang::app.contact.delete')
        ]);
    }
}