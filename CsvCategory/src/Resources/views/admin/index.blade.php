@extends('admin::layouts.master')

@section('page_title')
    Import Categories
@stop

@section('content-wrapper')

@push('css')
    <style>
        input#categories_file {
            background: #fff;
    border: 2px solid #c7c7c7;
    border-radius: 3px;
    width: 40%;
    height: 36px;
    display: inline-block;
    vertical-align: middle;
    transition: .2s cubic-bezier(.4,0,.2,1);
    padding: 0 10px;
    font-size: 15px;
    margin-top: 10px;
    margin-bottom: 5px
}
label.category_label {
    font-size: 15px;
    color: black;
}
/*  */
.flash-message {
    padding: 1em;
    margin-bottom: 1em;
    border-radius: 0.25em;
    font-weight: bold;
}

.success {
    background-color: #c8e6c9;
    color: #2e7d32;
}

.error {
    background-color: #ffcdd2;
    color: #c62828;
}
.flash-message.error {
    margin-top: 30px;
    margin-left: 17px;
    margin-right: 20px;
}

.flash-message.success {
    margin-top: 30px;
    margin-left: 17px;
    margin-right: 20px;
}
/*  */
    </style>
@endpush
    <div class="content full-page dashboard">
        <div class="page-header">
            <div class="page-title">
                <h1>Import Categories</h1>
            </div>
            <div class="page-action"></div>
        </div>
        <div class="page-content">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="categories_file" class="category_label">Upload Categories CSV File</label><br>
                    <input type="file" class="form-control" id="categories_file" name="categories_file" accept=".csv" Required>
                </div>
                <br>
                <button type="submit" class="btn btn-lg btn-primary">Import Categories</button>
            </form>
        </div>
        <!--  -->
        @if(session('error'))
        <div class="flash-message error">
        {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="flash-message success">
        {{ session('success') }}
        </div>
        @endif
        <!--  -->
    </div>
@stop
