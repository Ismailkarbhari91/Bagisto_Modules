<?php

namespace Webkul\Blog\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog_Post extends Model {
    use HasFactory;

    protected $table = 'blog_post';
    protected $fillable = [
        'title',
        'post_category_name',
        'post_slug',
        'description',
        'image',
        'locale',
        'status'
    ];

//     public function blogCategory()
//     {
//         return $this->belongsTo(BlogCategory::class, 'category_name', 'category_name');
//     }

//     public function images()
// {
//     return $this->hasMany(BlogPostImage::class);
// }
}