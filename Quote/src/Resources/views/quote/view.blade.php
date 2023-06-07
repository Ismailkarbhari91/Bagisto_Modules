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
                <h1>{{ __('quote_lang::app.quote.view_title') }} of "{{ $quote->name}}"</h1>

                <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ url('/admin/dashboard') }}';"></i>

            </div>
            <div class="page-action">
         
         <button type="submit" class="btn btn-lg btn-primary">
            Update Status
         </button>
     </div>
        </div>

        <div class="page-content">

            <div>
                <table>
                    <tr>
                        <th>Name</th>
                        <td>{{$quote->name}}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{$quote->email}}</td>
                    </tr>
                    <tr>
                        <th>Phone-Number</th>
                        <td>{{$quote->phone}}</td>
                    </tr>
                    <tr>
                        <th>Quantity</th>
                        <td>{{$quote->quantity}}</td>
                    </tr>
                    <!-- <tr>
                        <th>Country</th>
                        <td>{{$quote->country}}</td>
                    </tr> -->
                    <!-- <tr>
                        <th>Pincode</th>
                        <td>{{$quote->pincode}}</td>
                    </tr> -->
                    <!-- <tr> 
                        <th>Delivery location type</th>
                        <td>{{$quote->locationtype}}</td>
                    </tr> -->
                    <tr>
                        <th>Message</th>
                        <td>{{$quote->message_body}}</td>
                    </tr>
                    <!-- <tr>
                        <th>Delivery Date</th>
                        <td>{{$quote->date}}</td>
                    </tr> -->
                    <!-- <tr>
                        <th>Company Name</th>
                        <td>{{$quote->company_name}}</td>
                    </tr> -->
                    <!-- <tr>
                        <th>Currency</th>
                        <td>{{$quote->pcurrency}}</td>
                    </tr> -->
                    <tr>
                        <th>id</th>
                        <td>{{$quote->id}}</td>
                    </tr>
                </table>
            </div>

            <div class="message">
            <div class="form-group"> 
                             <label id="labelstatus" class="cd-label" for="cd-textarea">Status</label>
                             <select id="selectstatus" name="quotestatus" class="text-input  form-style">
                <option value="">Select Status</option>
                <option value="Won" <?php 
                if($quote->quotestatus=="Won")
                {
                    echo "selected";
                } ?>>Won</option>  
                <option value="Lost" <?php 
                if($quote->quotestatus=="Lost")
                {
                    echo "selected";
                } ?>>Lost</option>
            </select>
                          </div> 
                          <input type="hidden"  name="ID" value= "{{$quote->id}}">
            </div>
        </div>
</form>
    </div>


@stop

