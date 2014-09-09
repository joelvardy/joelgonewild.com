<?php

use Travel\Blog;

Flight::route('GET /', function () {

	Flight::render('home', [
		'posts' => Blog::posts()
	]);

});
