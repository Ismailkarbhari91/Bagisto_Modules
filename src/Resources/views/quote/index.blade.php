@extends('admin::layouts.content')

@section('page_title')
    {{ 'Quotation' }}
@stop

@section('content')

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>{{ __('quote_lang::app.quote.title') }}</h1>
            </div>
        </div>

        <div class="page-content">
            @inject('contactGrid','Webkul\Quote\DataGrids\ContactDataGrid')

            {!! $contactGrid->render() !!}
        </div>
   
 </div>
<pre>

</pre>
@stop

