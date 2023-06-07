@extends('admin::layouts.content')

@section('page_title')
    {{ __('quote_lang::app.contact.view_title') }}
@stop

<style>
    table{
        margin-top: 20px;
        width:100%;
        border-collapse:collapse;
        border:1px solid #00F;
        font-size:13px;
    }

    table tr{
        padding: 10px;
    }

    table tr th{
        padding: 10px;
        border: 1px solid #e9e9e9;
        font-size: 16px;
        font-weight: bold;
    }

    table tr td{
        padding: 10px;
        border: 1px solid #e9e9e9;
    }

    .message{
        background: #e9e9e9;
        padding: 15px;
        border: 1px solid #ccc;
        margin-top: 20px;
        font-size: 16px;
    }
</style>

@section('content')

    <div class="content">
    <form class="cd-form floating-labels" action="{{ route('admin.quote.status-message') }}" method="post">
    @csrf
        <div class="page-header" style="border-bottom: 1px solid #e9e9e9">
            <div class="page-title">
                <h1>hello</h1>

                <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

            </div>
            <div class="page-action">
         
                    <button type="submit" class="btn btn-lg btn-primary">
                        {{ __('admin::app.customers.note.save-note') }}
                    </button>
                </div>
        </div>

        <div class="page-content">

        <div class="form-group"> 
                             <label class="cd-label" for="cd-textarea">Status</label>
                             <select name="quotestatus" class="text-input  form-style">
                <option value="">Select Status</option>
                <option value="Own">Own</option>  
                <option value="Lost">Lost</option>
            </select>
                          </div> 

                          <input type="text"  name="ID" value= "{{$quote->id}}">

            </div>

            <!-- <div class="message">
                 
            </div> -->
        </div>

        <!-- {{$quote->ID}} -->
</form>
    </div>


@stop

