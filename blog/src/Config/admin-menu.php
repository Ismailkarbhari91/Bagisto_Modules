<?php

return [
    [
      'key'        => 'blog',
      'name'       => 'Blog',
      'route'      => 'blog.admin.index',
      'sort'       => 10,
      'icon-class' => 'catalog-icon',
    ],
    [
        'key' 			=> 'blog.category',
        'name' 			=> 'Blog Caegory',
        'route' 		=> 'blog.admin.index',
        'sort' 			=> 1,
        'icon-class'    => ''
    ],
    [
        'key' 			=> 'blog.post',
        'name' 			=> 'Blog Post',
        'route' 		=> 'blog.admin.postindex',
        'sort' 			=> 2,
        'icon-class'    => ''
    ],
];
