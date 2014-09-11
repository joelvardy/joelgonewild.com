<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<title><?php echo $category->title; ?> | Travel Blog | Joel Vardy</title>
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

			<section class="category">

				<h2><?php echo $category->title; ?></h2>
				<p><?php echo $category->description; ?></p>

			</section>

			<section class="posts">
				<?php foreach ($category->posts as $post) : ?>

					<article class="post">

						<?php if (isset($post->heroPhoto)) : ?>
							<div class="photo hero" data-path="/<?php echo $post->category->slug.'/'.$post->slug.'/'.$post->heroPhoto; ?>"></div>
						<?php endif; ?>

						<hgroup>
							<h2><a href="/<?php echo $post->category->slug; ?>/<?php echo $post->slug; ?>" title="<?php echo $post->category->title; ?> full post"><?php echo $post->title; ?></a></h2>
							<h4><?php echo date('l jS F Y', $post->written); ?></h4>
						</hgroup>

						<div class="introduction">
							<?php echo $post->introduction; ?>
						</div>

						<a class="read-more" href="/<?php echo $post->category->slug; ?>/<?php echo $post->slug; ?>" title="<?php echo $post->category->title; ?> full post">Read more&hellip;</a>

					</article>

				<?php endforeach; ?>
			</section>

		</div>

		<script src="/assets/js/main.js"></script>
	</body>
</html>
