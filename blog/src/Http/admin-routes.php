<?php

use Webkul\Blog\Http\Controllers\BlogCategoryController;
use Webkul\Blog\Http\Controllers\BlogPostController;


Route::group(['middleware' => ['web', 'admin']], function () {
  Route::prefix(config('app.admin_url'))->group(function () {

    // all admin routes will place 
    
    // Route::view('/blog', 'blog::admin.index');

    Route::view('/admin/blog', 'blog::admin.index')->name('blog.admin.index');

    Route::get('/blog-category/create', [BlogCategoryController::class, 'create'])->defaults('_config', [
        'view' => 'blog::admin.create',
    ])->name('blog.categories.create');

    Route::post('/blog-category/create', [BlogCategoryController::class, 'store'])->defaults('_config', [
        'redirect' => 'blog.admin.index',
    ])->name('blog.categories.create.store');


    Route::get('/blog-category/create/{id}', [BlogCategoryController::class, 'edit'])->defaults('_config', [
      'view' => 'blog::admin.edit',
  ])->name('blog.categories.edit');

  Route::post('/blog-category/update/{id}', [BlogCategoryController::class, 'update'])->defaults('_config', [
    'redirect' => 'blog.admin.index',
])->name('blog.categories.update');

Route::post('/blog-category/delete/{id}', [BlogCategoryController::class, 'destroy'])->defaults('_config', [
  'redirect' => 'blog.admin.index',
])->name('blog.categories.delete');
// 

Route::view('/admin/blog-post', 'blog::admin.postindex')->name('blog.admin.postindex');

Route::get('/blog-post/create', [BlogPostController::class, 'create'])->defaults('_config', [
  'view' => 'blog::admin.postcreate',
])->name('blog.post.create');


Route::post('/blog-post/create', [BlogPostController::class, 'store'])->defaults('_config', [
  'redirect' => 'blog.admin.postindex',
])->name('blog.post.creates.store');

Route::get('/blog-post/create/{id}', [BlogPostController::class, 'edit'])->defaults('_config', [
  'view' => 'blog::admin.postedit',
])->name('blog.post.edit');


Route::post('/blog-post/update/{id}', [BlogPostController::class, 'update'])->defaults('_config', [
  'redirect' => 'blog.admin.postindex',
])->name('blog.post.update');

Route::post('/blog-post/delete/{id}', [BlogPostController::class, 'destroy'])->defaults('_config', [
  'redirect' => 'blog.admin.postindex',
])->name('blog.post.delete');

// 


  });
});
