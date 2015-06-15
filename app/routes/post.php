<?php

use Travel\Blog;

Flight::route('GET /@category/@post', function ($category_slug, $post_slug) {

    // Ensure category exists
	$category = Blog::category($category_slug);
	if ( ! $category) Flight::halt(404);

    // Ensure post exists
	$post = Blog::post($category_slug, $post_slug);
	if ( ! $post) Flight::halt(404);

	Flight::render('post', [
		'post' => $post
	]);

});
