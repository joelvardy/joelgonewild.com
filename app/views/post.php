<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $post->title; ?> | Travel Blog | Joel Vardy</title>
		<script src="//use.typekit.net/pel3gnp.js"></script>
		<script>try{Typekit.load();}catch(e){}</script>
		<link rel="stylesheet" href="/assets/css/design.css" />
	</head>
	<body>

		<header>
			<a href="/" title="List of posts">
				<img src="/assets/img/icon.svg" />
				<h1>Travel Blog</h1>
			</a>
		</header>

		<div class="container">

			<?php var_dump($post); ?>

		</div>

		<script src="/assets/js/main.js"></script>
	</body>
</html>
