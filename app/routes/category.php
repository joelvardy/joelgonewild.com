<?php

use Travel\Blog;

Flight::route('GET /category/@category', function ($category_slug) {

	$category = Blog::category($category_slug);
	if ( ! $category) return false;

	Flight::render('category', [
		'category' => $category
	]);

});
