@extends('admin::layouts.content')

@section('page_title')
    {{ __('Blog Post') }}
@stop

@section('content')
@push('css')
    <style>
        
        
    </style>
@endpush
    <div class="content">
        <form method="POST" action="{{ route('blog.post.update', ['id' => $blogPost->id]) }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('blog.admin.postindex') }}'"></i>

                        {{ __('Add Blog Post') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('Update Blog Post') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                
                <div class="form-container">
                    @csrf()
                    <accordian :title="'{{ 'Blog Post' }}'" :active="true">
                    <div slot="body">
            
                        <div class="control-group">
                            <label class="required">{{ 'Title' }}</label>
                            <input id="title" name="title" type="text" class="control" value="{{ $blogPost->title }}">
                        </div>

                        <!--  -->

                        <div class="control-group">
    <label for="category" class="required">{{ __('Category') }}</label>
    <select class="control" id="post_category_name" name="post_category_name">
        @foreach($categories as $categoryId => $categoryName)
            <option value="{{ $categoryId }}" {{ $categoryId == $blogPost->post_category_name ? 'selected' : '' }}>
                {{ $categoryName }}
            </option>
        @endforeach
    </select>
</div>



                        <!--  -->
                    <!--  -->
                    <div class="control-group">
                            <label class="required">{{ 'Slug' }}</label>
                            <input id="post_slug" name="post_slug" type="text" class="control" value="{{ $blogPost->post_slug }}">
                    </div>

                    <!--  -->
                    <description :descriptions="'{{ $descriptions }}'"></description>




                    <!--  -->
            
                    <!--  -->
                    <div class="control-group {!! $errors->has('image.*') ? 'has-error' : '' !!}">
                    <label>{{ __('Blog Post Images') }}</label>

                                <image-wrapper button-label="{{ __('admin::app.catalog.products.add-image-btn-title') }}" input-name="image" :multiple="false" :images="{{ json_encode($imageURL) }}"></image-wrapper>

                    </div>
                    <!--  -->
                    <!-- <div class="control-group">
                                <label for="status" class="required">{{ __('Locale') }}</label>
                                <select class="control" id="locale" name="locale">
                                    <option value="en" {{ $blogPost->locale == 'en' ? 'selected' : '' }}>
                                        {{ __('English') }}
                                    </option>
                                    <option value="fr" {{ $blogPost->locale == 'fr' ? 'selected' : '' }}>
                                        {{ __('French') }}
                                    </option>
                                </select>
                            </div> -->


                            <div class="control-group">
    <label for="status" class="required">{{ __('Locale') }}</label>
    <select class="control" id="locale" name="locale">
        @foreach($localeCodes as $locale)
            <option value="{{ $locale }}" {{ $blogPost->locale == $locale ? 'selected' : '' }}>
                {{ $locale }}
            </option>
        @endforeach
    </select>
</div>

                    <!--  -->
                    <!--  -->
                    <div class="control-group">
                                <label for="status" class="required">{{ __('Status') }}</label>
                                <select class="control" id="status" name="status">
                                    <option value="Draft" {{ $blogPost->status == 'Draft' ?'selected' : ''}}>
                                        {{ __('Draft') }}
                                    </option>
                                    <option value="Publish" {{ $blogPost->status == 'Publish' ?'selected' : ''}}>
                                        {{ __('Publish') }}
                                    </option>
                                </select>
                    </div>

                    <!--  -->
                    </div>
                </accordian>
                </div>
            </div>
        </form>
    </div>
@stop
@push('scripts')
    @include('admin::layouts.tinymce')

    <script type="text/x-template" id="description-template">
    <div class="control-group" :class="[errors.has('description') ? 'has-error' : '']">
        <label for="description" :class="isRequired ? 'required' : ''">{{ __('admin::app.catalog.categories.description') }}</label>
        <textarea v-validate="isRequired ? 'required' : ''" class="control" id="description" name="description" data-vv-as="{{ __('admin::app.catalog.categories.description') }}">{{ $descriptions }}</textarea>

        <span class="control-error" v-if="errors.has('description')">@{{ errors.first('description') }}</span>
    </div>
</script>



    <script>
        Vue.component('description', {
            template: '#description-template',

            inject: ['$validator'],

            props: ['descriptions'],

            data: function() {
                return {
                    isRequired: true,
                }
            },

            created: function () {
                let self = this;

                $(document).ready(function () {
                   
                    // 
                    $('#title').on('input', function() {
                    var category_name = $(this).val();
                    var slug = category_name.toLowerCase().replace(/[^a-z0-9]+/g, '-');
                    $('#post_slug').val(slug);
                    });
                    // 

                    tinyMCEHelper.initTinyMCE({
                        selector: 'textarea#description',
                        height: 200,
                        width: "100%",
                        plugins: 'image imagetools media wordcount save fullscreen code table lists link hr',
                        toolbar1: 'formatselect | bold italic strikethrough forecolor backcolor link hr | alignleft aligncenter alignright alignjustify | numlist bullist outdent indent  | removeformat | code | table',
                    });
                });
            },
        });
    </script>
@endpush