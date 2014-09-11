<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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

			<div class="post">

				<?php if (isset($post->heroPhoto)) : ?>
					<div class="photo hero" data-path="/<?php echo $post->category->slug.'/'.$post->slug.'/'.$post->heroPhoto; ?>"></div>
				<?php endif; ?>

				<hgroup>
					<h2><?php echo $post->title; ?></h2>
					<h4><?php echo date('l jS F Y', $post->written); ?></h4>
				</hgroup>

				<?php echo $post->html; ?>

			</div>

		</div>

		<script src="/assets/js/main.js"></script>
	</body>
</html>
