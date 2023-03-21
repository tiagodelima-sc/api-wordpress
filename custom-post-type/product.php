<?php

function register_product(){

  register_post_type('product', [
    'label' => 'Produto',
    'description' => 'Produto',
    'public' => true,
    'show_ui' => true,
    'capability_type' => 'post',
    'rewrite' => ['slug' => 'product', 'with_front' => true],
    'query_var' => true,
    'supports' => ['custom-fields', 'author', 'title'],
    'publicly_queryable' => true
  ]);
}

add_action('init', 'register_product');
