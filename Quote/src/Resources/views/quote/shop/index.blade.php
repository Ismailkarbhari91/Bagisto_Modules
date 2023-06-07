@extends('shop::layouts.master')

@section('page_title')
    {{ __('quote_lang::app.shop.title') }}
@endsection

@section('content-wrapper')
@php
$pid=0;
if (isset($_GET['pid'])) {
$pid=$_GET['pid'];
}

@endphp
    <div class="auth-content form-container">
        <div class="container quote-page">
            <div class="col-lg-8 col-md-12 offset-lg-2">
                {{-- <div class="heading">
                    <h2 class="fs24 fw6">
                        {{ __('quote_lang::app.shop.title') }}
                    </h2>
                </div> --}}

                <div class="body col-12 quote-form">
                    <h3 class="fw6">
                    Get quote
                    </h3>

                    <p class="fs16">
                        If you want to know something, just send us a message, we glad to hear from you.
                    </p>

                    <form class="cd-form floating-labels" action="{{ route('shop.quote.send-message') }}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                             <label class="cd-label" for="cd-mobile">Preferred quantity*</label>
                             <input class="text-input  form-style" type="number" name="quantity" id="cd-mobile" required>
                          </div> 

                        <div class="form-group"> 
                             <label class="cd-label" for="cd-textarea">Destination Country*</label>
                             <select name="country" class="text-input  form-style" required>
                <option value="">Select Country</option>

                @foreach (core()->countries() as $country)
                    <option value="{{ $country->code }}">{{ $country->name }}</option>
                @endforeach
            </select>

                          </div> 

                          <div class="form-group">
                             <label class="cd-label" for="cd-mobile">Destination Pin Code*</label>
                             <input class="text-input  form-style" type="number" name="pincode" id="cd-mobile" required>
                          </div> 


                          <div class="form-group"> 
                             <label class="cd-label" for="cd-textarea">Delivery location type</label>
                             <select name="locationtype" class="text-input  form-style">
                <option value="">Select location type</option>
                <option value="Home">Home</option>  
                <option value="Store">Store</option>  
                <option value="Office">Office</option>
                <option value="Warehouse">Warehouse</option>
                <option value="Amazone House">Amazone House</option>
                <option value="Others">Others</option>
            </select>

                          </div> 

                          <div class="form-group">
                             <label class="cd-label" for="cd-textarea">Please share any customization requirement (color, size, packaging etc.)</label>
                             <textarea class="message  form-control" name="message_body" rows="5" id="cd-textarea"></textarea>
                          </div>

                          <div class="form-group">
                             <label class="cd-label " for="cd-name">What is your required delivery date?</label>
                             <input class="text-input form-style" type="date" id="cd-mobile" name="date">
                          </div> 

                          <div class="form-group"> 
                             <label class="cd-label" for="cd-textarea">Preferred currency for quotation</label>
                             <select name="pcurrency" class="text-input  form-style">
                <option value="">Select Preferred currency</option>
                <option value="INR">INR</option>  
                <option value="USD">USD</option>  
                <option value="AUD">AUD</option>
                <option value="EUR">EUR</option>
                <option value="GBP">GBP</option>
            </select>

                          </div> 
                         <!--  -->

                         <h3 class="fw6">
                         Please share your details so we can respond:
                    </h3>

                    <p class="fs16">
                    Your information is safe with us.
                    </p>

                          <div class="form-group">
                             <label class="cd-label " for="cd-name">Name*</label>
                             <input class="text-input form-style" type="text" name="name" id="cd-name" required>
                          </div> 

                          <div class="form-group">
                             <label class="cd-label " for="cd-name">Company Name*</label>
                             <input class="text-input form-style" type="text" name="company_name" id="cd-name" required>
                          </div> 

                          <div class="form-group">
                             <label class="cd-label" for="cd-email">Email*</label>
                             <input class="text-input  form-style" type="email" name="email" id="cd-email" required>
                          </div> 

                           <div class="form-group">
                             <label class="cd-label" for="cd-mobile">Phone Number*</label>
                             <input class="text-input  form-style" type="number" name="phone" id="cd-mobile" required>
                          </div> 
                          <input type="hidden" value="{{$pid}}" name="pid">
                          <div>
                             <button type="submit" class="theme-btn btn-block p-3"><i class="fa fa-paper-plane"></i> Send Message</button>
                          </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection