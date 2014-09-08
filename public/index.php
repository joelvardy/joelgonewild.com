<?php

require(dirname(__DIR__).'/init.php');

Flight::route('GET /', function () {
	echo 'Hello World!';
});

Flight::start();
