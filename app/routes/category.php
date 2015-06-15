<?php

use Travel\Blog;

Flight::route('GET /category/@category', function ($category_slug) {

    // Ensure category exists
	$category = Blog::category($category_slug);
	if ( ! $category) Flight::halt(404);

	Flight::render('category', [
		'category' => $category
	]);

});
