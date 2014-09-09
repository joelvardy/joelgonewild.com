<!DOCTYPE html>
<html>
	<head>
		<title>Travel Blog | Joel Vardy</title>
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

		<div class="container sidebar">

			<section class="posts">
				<?php foreach ($posts as $post) : ?>

					<article class="post">

						<?php if (isset($post->heroPhoto)) : ?>
							<?php var_dump($post->heroPhoto); ?>
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

			<aside>

				<ul class="categories">
					<?php foreach ($categories as $category) : ?>
						<li><a href="/category/<?php echo $category->slug; ?>" title="View posts from <?php echo $category->title; ?>"><?php echo $category->title; ?></a></li>
					<?php endforeach; ?>
				</ul>

			</aside>

		</div>

		<script src="/assets/js/main.js"></script>
	</body>
</html>
