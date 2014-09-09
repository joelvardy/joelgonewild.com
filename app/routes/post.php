<?php

use Travel\Blog;

Flight::route('GET /@category/@post', function ($category_slug, $post_slug) {

	$category = Blog::category($category_slug);
	if ( ! $category) return false;

	$post = Blog::post($category_slug, $post_slug);
	if ( ! $post) return false;

	Flight::render('post', [
		'post' => $post
	]);

});
