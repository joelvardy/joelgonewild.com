<?php

use Travel\Blog;

Flight::route('GET /', function () {

	Flight::render('home', [
		'categories' => Blog::categories(),
		'posts' => Blog::posts()
	]);

});
