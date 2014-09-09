<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $category->title; ?> | Travel Blog | Joel Vardy</title>
		<script src="//use.typekit.net/pel3gnp.js"></script>
		<script>try{Typekit.load();}catch(e){}</script>
		<link rel="stylesheet" href="/assets/css/design.css" />
	</head>
	<body>

		<header>
			<h1>Travel Blog</h1>
		</header>

		<div class="container">

			<section class="category">
				<?php var_dump($category); ?>
			</section>

			<section class="posts">
				<?php foreach ($category->posts as $post) : ?>

					<article class="post">

						<?php if (isset($post->heroPhoto)) : ?>
							<div class="photo hero" style="background-image: url('/<?php echo $post->category->slug.'/'.$post->slug.'/'.$post->heroPhoto; ?>/1200');"></div>
						<?php endif; ?>

						<hgroup>
							<h2><a href="/<?php echo $post->category->slug; ?>/<?php echo $post->slug; ?>" title="<?php echo $post->category->title; ?> full post"><?php echo $post->title; ?></a></h2>
							<h4><?php echo date('l jS F Y', $post->written); ?></h4>
						</hgroup>

						<div class="introduction">
							<?php echo 'POST'; ?>
						</div>

					</article>

				<?php endforeach; ?>
			</section>

		</div>

		<script src="/assets/js/main.js"></script>
	</body>
</html>
