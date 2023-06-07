<?php

namespace Webkul\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog_Category extends Model {
    use HasFactory;

    protected $table = 'blog_category';
    protected $fillable = [
        'category_name',
        'slug',
        'locale'
    ];

    // public function blogPosts()
    // {
    //     return $this->hasMany(BlogPost::class, 'category_name', 'category_name');
    // }
}