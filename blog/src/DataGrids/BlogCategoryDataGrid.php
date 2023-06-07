<?php

namespace Webkul\Blog\DataGrids;

use Webkul\Ui\DataGrid\DataGrid;
use DB;


class BlogCategoryDataGrid extends DataGrid
{
    
    protected $index = 'blogcategory_id'; //the column that needs to be treated as index column

    protected $sortOrder = 'desc'; //asc or desc

    protected $itemsPerPage = 50;

    public function prepareQueryBuilder()
    {
        // $queryBuilder = DB::table('blog_category')
        //         ->join('blog_post','blog_category.id' ,'=', 'blog_post.post_category_name')
        //         ->addSelect('blog_category.id as blogcategory_id', 'blog_category.category_name as cname', 'blog_category.slug as slug','blog_category.locale as locale');

        $queryBuilder = DB::table('blog_category')
    ->join('blog_post', 'blog_category.id', '=', 'blog_post.post_category_name')
    ->select('blog_category.id as blogcategory_id', 'blog_category.category_name as cname', 'blog_category.slug as slug', 'blog_category.locale as locale')
    ->selectRaw('COUNT(blog_post.post_category_name) as post_count')
    ->groupBy('blog_category.id', 'blog_category.category_name', 'blog_category.slug', 'blog_category.locale');



        $this->addFilter('blogcategory_id', 'blog_category.id');

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
            'index' => 'post_count',
            'label' => trans('Number Of post'),
            'type' => 'number',
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
    

    }

    public function prepareActions() {
        $this->addAction([
            'type' => 'Edit',
            'method' => 'GET', // use GET request only for redirect purposes
            'route' => 'blog.categories.edit',
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
            'route' => 'blog.categories.delete',
            'icon' => 'icon trash-icon',
            'title' => trans('Delete')
        ]);
    }
}