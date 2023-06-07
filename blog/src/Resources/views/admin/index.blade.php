@extends('admin::layouts.master') @section('page_title') Blog
@stop @section('content-wrapper')

<div class="content full-page dashboard">
  <div class="page-header">
    <div class="page-title">
    <h1>{{ __('Blog Category') }}</h1>
    </div>

    <div class="page-action">
    <a
                    href="{{ route('blog.categories.create') }}"
                    class="btn btn-lg btn-primary"
                >
                    {{ __('Add Blog Category') }}
                </a>
    </div>
  </div>

  <div class="page-content">
  @inject('blogcategoryGrid','Webkul\Blog\DataGrids\BlogCategoryDataGrid')

    {!! $blogcategoryGrid->render() !!}
  </div>
  </div>

@stop

