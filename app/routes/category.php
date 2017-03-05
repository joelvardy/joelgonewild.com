<?php

use Travel\Blog;

Flight::route('GET /category/@category', function ($category_slug) {

    // Ensure category exists
    if (!$category = Blog::category($category_slug)) {
        Flight::halt(404);
    }

    Flight::render('category', [
        'category' => $category,
    ], 'content');

    Flight::render('template', [
        'page_title' => sprintf('%s | Travel Blog | Joel Vardy', $category->title),
        'page_description' => $category->description,
        'og_title' => $category->title,
        'og_image' => 'https://joelgonewild.com/img/joel-vardy.jpg',
    ]);

});
