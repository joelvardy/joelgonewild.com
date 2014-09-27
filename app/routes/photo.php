<?php

use Travel\Blog;
use Travel\Photo;

Flight::route('GET /@category/@post/@photo(/@size)(.jpg)', function ($category_slug, $post_slug, $photo_slug, $size) {

	$category = Blog::category($category_slug);
	if ( ! $category) Flight::halt(404);

	$post = Blog::post($category_slug, $post_slug);
	if ( ! $post) Flight::halt(404);

	if ( ! isset($post->photos[$photo_slug])) Flight::halt(404);

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
