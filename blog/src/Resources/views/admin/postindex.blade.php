@extends('admin::layouts.master') @section('page_title') Blog
@stop @section('content-wrapper')

<div class="content full-page dashboard">
  <div class="page-header">
    <div class="page-title">
    <h1>{{ __('Blog Post') }}</h1>
    </div>

    <div class="page-action">
    <a
                    href="{{ route('blog.post.create') }}"
                    class="btn btn-lg btn-primary"
                >
                    {{ __('Add Blog Post') }}
                </a>
    </div>
  </div>

  <div class="page-content">
  @inject('blogpostGrid','Webkul\Blog\DataGrids\BlogPostDataGrid')

    {!! $blogpostGrid->render() !!}
  </div>
  </div>

@stop

