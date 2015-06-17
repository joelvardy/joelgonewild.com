<!DOCTYPE html>
<html>
	<head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Travel Blog | Joel Vardy</title>
		<script src="//use.typekit.net/pel3gnp.js"></script>
		<script>try{Typekit.load();}catch(e){}</script>
		<link rel="stylesheet" href="/assets/css/design.css">
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
							<a class="photo hero" href="/<?php echo $post->category->slug; ?>/<?php echo $post->slug; ?>" title="<?php echo $post->category->title; ?> full post" data-path="/<?php echo $post->category->slug.'/'.$post->slug.'/'.$post->heroPhoto; ?>"></a>
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

			<aside>

				<div class="biography">

                    <a href="https://joelvardy.com/" title="Learn a little more about me"><img src="/assets/img/joel-vardy.jpg"></a>

					<p>I'm Joel Vardy, a <?php echo floor((time() - strtotime('10th Jan 1993')) / 31557600); ?> year old web developer. I've never really blogged (diary style) before, but I'm trying to document some of my trips for the future.</p>

				</div>

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
