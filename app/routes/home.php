<?php

use Travel\Blog;

Flight::route('GET /', function () {

    Flight::render('home', [
        'categories' => Blog::categories(),
        'posts' => Blog::posts(),
    ], 'content');

    Flight::render('template', [
        'page_title' => 'Travel Blog | Joel Vardy',
        'page_description' => 'My personal musings when traveling around.',
        'og_title' => 'Traveling with Joel',
        'og_image' => 'https://joelgonewild.com/img/joel-vardy.jpg',
    ]);

});
