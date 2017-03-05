<?php

use Travel\Blog;

Flight::route('GET /@category/@post', function ($category_slug, $post_slug) {

    // Ensure category exists
    if (!$category = Blog::category($category_slug)) {
        Flight::halt(404);
    }

    // Ensure post exists
    if (!$post = Blog::post($category_slug, $post_slug)) {
        Flight::halt(404);
    }

    Flight::render('post', [
        'post' => $post,
    ], 'content');

    Flight::render('template', [
        'page_title' => sprintf('%s | Travel Blog | Joel Vardy', $post->title),
        'page_description' => $post->description,
        'og_title' => sprintf('%s with Joel', $post->title),
        'og_image' => sprintf('https://joelgonewild.com/%s/%s/%s/600.jpg', $post->category->slug, $post->slug, $post->heroPhoto),
    ]);

});
