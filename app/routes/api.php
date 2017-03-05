<?php

use Travel\Blog;

Flight::route('GET /api/category', function () {

    Flight::json([
        'categories' => Blog::categories(),
    ]);

});
