<?php

use Travel\Blog;

Flight::route('GET /@category/@post', function ($category_slug, $post_slug) {

	$category = Blog::category($category_slug);
	if ( ! $category) Flight::halt(404);

	$post = Blog::post($category_slug, $post_slug);
	if ( ! $post) Flight::halt(404);

	Flight::render('post', [
		'post' => $post
	]);

});
