<?php


Route::group(['middleware' => ['web', 'admin']], function () {
    Route::prefix(config('app.admin_url'))->group(function () {


    Route::get('admin/quote', 'Webkul\Quote\Http\Controllers\QuoteController@index')
        ->defaults('_config', ['view' => 'quote_view::quote.index'])
        ->name('admin.quote.index');
// 

    Route::get('admin/quote/status/{id}', 'Webkul\Quote\Http\Controllers\QuoteController@quotestatus')
        ->defaults('_config', ['view' => 'quote_view::quote.status'])
        ->name('admin.quote.statusquote');

// 

    Route::post('admin/quote/status', 'Webkul\Quote\Http\Controllers\QuoteController@updatestatus')
        ->defaults('_config',['redirect' => 'admin.quote.index'])
        ->name('admin.quote.status-message');
        



    Route::get('admin/quote/view/{id}', 'Webkul\Quote\Http\Controllers\QuoteController@view')
        ->defaults('_config', ['view' => 'quote_view::quote.view'])
        ->name('admin.quote.view');

         Route::get('admin/quote', 'Webkul\Quote\Http\Controllers\QuoteController@index')
        ->defaults('_config', ['view' => 'quote_view::quote.index'])
        ->name('admin.quote.index');

    Route::post('admin/quote/delete/{id}', 'Webkul\Quote\Http\Controllers\QuoteController@destroy')
        ->name('admin.quote.delete');

    });
});



Route::group(['middleware' => ['web', 'locale', 'theme', 'currency']], function () {

// Registration Routes
    
    Route::get('/quote', 'Webkul\Quote\Http\Controllers\QuoteController@show')
    		->defaults('_config', ['view' => 'quote_view::quote.shop.index'])
    		->name('shop.quote.index');
    
    Route::post('/quote', 'Webkul\Quote\Http\Controllers\QuoteController@sendMessage')
    		->defaults('_config',['redirect' => 'shop.quote.index'])
    		->name('shop.quote.send-message');




});