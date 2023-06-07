<?php

namespace Webkul\Blog\DataGrids;

use Webkul\Ui\DataGrid\DataGrid;
use DB;


class BlogPostDataGrid extends DataGrid
{
    
    protected $index = 'blogcategory_id'; //the column that needs to be treated as index column

    protected $sortOrder = 'desc'; //asc or desc

    protected $itemsPerPage = 50;

    public function prepareQueryBuilder()
    {
        $queryBuilder = DB::table('blog_post')
                ->join('blog_category','blog_post.post_category_name' ,'=', 'blog_category.id')
                ->addSelect('blog_post.id as blogcategory_id','blog_post.title as title' ,'blog_category.category_name as cname', 'blog_post.post_slug as slug','blog_post.locale as locale','blog_post.status as status');



        $this->addFilter('blogcategory_id', 'blog_post.id');

        $this->setQueryBuilder($queryBuilder);
    }

    public function addColumns()
    {

        $this->addColumn([
            'index' => 'blogcategory_id',
            'label' => trans('Id'),
            'type' => 'number',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'title',
            'label' => trans('Title'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => true
        ]);

        $this->addColumn([
            'index' => 'cname',
            'label' => trans('Category Name'),
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => false
        ]);

        $this->addColumn([
            'index' => 'slug',
            'label' => trans('Slug'),
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => false
        ]);
        
        $this->addColumn([
            'index' => 'locale',
            'label' => 'Locale',
            'type' => 'string',
            'searchable' => false,
            'sortable' => true,
            'filterable' => false,
            // 'wrapper' => function ($value) {
            //     if (str($value->locale) == 'en')
            //         return str('English');
            //     else
            //         return str('French');
            // }
        ]);

        $this->addColumn([
            'index' => 'status',
            'label' => 'Status',
            'type' => 'string',
            'searchable' => true,
            'sortable' => true,
            'filterable' => false
        ]);

    }

    public function prepareActions() {
        $this->addAction([
            'type' => 'Edit',
            'method' => 'GET', // use GET request only for redirect purposes
            'route' => 'blog.post.edit',
            'icon' => 'icon pencil-lg-icon',
            'title' => trans('contact_lang::app.agent.edit-help-title')
        ]);


        // $this->addAction([
        //     'type' => 'View',
        //     'title'  => trans('admin::app.datagrid.edit'),
        //     'method' => 'GET',
        //     'route'  => 'admin.quote.statusquote',
        //     'icon'   => 'icon pencil-lg-icon',
        // ]);

        // $this->addAction([
        //     'type' => 'View',
        //     'method' => 'GET', // use GET request only for redirect purposes
        //     'route' => 'admin.quote.view',
        //     'icon' => 'icon pencil-lg-icon',
        //     'title' => trans('quote_lang::app.contact.view')
        // ]);




        $this->addAction([
            'type' => 'Delete',
            'method' => 'POST', // use GET request only for redirect purposes
            'route' => 'blog.post.delete',
            'icon' => 'icon trash-icon',
            'title' => trans('Delete')
        ]);
    }
}