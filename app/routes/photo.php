<?php

use Travel\Blog;
use Travel\Photo;

Flight::route('GET /@category/@post/@photo(/@size)', function ($category_slug, $post_slug, $photo_slug, $size) {

	$category = Blog::category($category_slug);
	if ( ! $category) return false;

	$post = Blog::post($category_slug, $post_slug);
	if ( ! $post) return false;

	if ( ! isset($post->photos[$photo_slug])) return false;

	$size = (integer) ($size === null ? 800 : $size);

	try {

		$resized_photo = Photo::resize($post->photos[$photo_slug]->path, $size);

		Flight::etag(md5_file($resized_photo));

		header('Content-Type: image/jpeg');
		readfile($resized_photo);

	} catch (Exception $e) {
		Flight::halt(500);
	}

});
