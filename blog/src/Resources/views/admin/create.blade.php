@extends('admin::layouts.content')

@section('page_title')
    {{ __('Blog Category') }}
@stop

@section('content')
    <div class="content">
        <form method="POST" action="{{ route('blog.categories.create.store') }}" @submit.prevent="onSubmit" enctype="multipart/form-data">
            <div class="page-header">
                <div class="page-title">
                    <h1>
                        <i class="icon angle-left-icon back-link" onclick="window.location = '{{ route('blog.admin.index') }}'"></i>

                        {{ __('Add Blog Category') }}
                    </h1>
                </div>

                <div class="page-action">
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('Save Blog Category') }}
                    </button>
                </div>
            </div>

            <div class="page-content">
                
                <div class="form-container">
                    @csrf()
                    <accordian :title="'{{ 'Blog Category' }}'" :active="true">
                    <div slot="body">
            
                        <div class="control-group">
                            <label class="required">{{ 'Category Name' }}</label>
                            <input id="category_name" name="category_name" type="text" class="control" value="">
                    </div>
                    <!--  -->
                    <div class="control-group">
                            <label class="required">{{ 'Slug' }}</label>
                            <input id="slug" name="slug" type="text" class="control" value="">
                    </div>

                    <!--  -->

                    <!--  -->
                    <!-- <div class="control-group">
                                <label for="status" class="required">{{ __('Locale') }}</label>
                                <select class="control" id="locale" name="locale">
                                    <option value="en">
                                        {{ __('English') }}
                                    </option>
                                    <option value="fr">
                                        {{ __('French') }}
                                    </option>
                                </select>
                    </div> -->

                    <!--  -->

                    <div class="control-group">
                                <label for="status" class="required">{{ __('Locale') }}</label>
                                <select class="control" id="locale" name="locale">
                                @foreach($localeCodes as $locale)
                                    <option value="{{ $locale }}">
                                        {{ $locale }}
                                    </option>
                                    @endforeach
                                </select>
                    </div>
                    </div>
                </accordian>
                </div>
            </div>
        </form>
    </div>
@stop
@push('scripts')
<script>
        $(document).ready(function() {
            $('#category_name').on('input', function() {
                var category_name = $(this).val();
                var slug = category_name.toLowerCase().replace(/[^a-z0-9]+/g, '-');
                $('#slug').val(slug);
            });
        });
    </script>
@endpush