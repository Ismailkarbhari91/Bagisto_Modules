<?php

Route::group(['middleware' => ['web', 'admin']], function () {
  Route::prefix(config('app.admin_url'))->group(function () {

    // all admin routes will place here


    Route::get('admin/category-upload', 'Webkul\CsvCategory\Http\Controllers\CategoryCsvController@index')
    ->defaults('_config', ['view' => 'csvcategory::admin.index'])
    ->name('category.admin.index');

    Route::post('admin/category-upload', 'Webkul\CsvCategory\Http\Controllers\CategoryCsvController@upload')
        ->defaults('_config',['redirect' => 'category.admin.index'])
        ->name('category.admin.uploadcsv');

  });
});
