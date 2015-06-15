<?php

use Travel\Blog;
use Travel\Photo;

Flight::route('GET /@category/@post/@photo(/@size)(.jpg)', function ($category_slug, $post_slug, $photo_slug, $size) {

    // Ensure category exists
	$category = Blog::category($category_slug);
	if ( ! $category) Flight::halt(404);

    // Ensure post exists
	$post = Blog::post($category_slug, $post_slug);
	if ( ! $post) Flight::halt(404);

    // Ensure photo exists
	if ( ! isset($post->photos[$photo_slug])) Flight::halt(404);

    // Get requested photo size
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
