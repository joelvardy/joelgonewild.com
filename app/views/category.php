<!DOCTYPE html>
<html>
	<head>
		<title>Travel Blog | Joel Vardy</title>
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

				<?php endforeach; ?>
			</section>

		</div>

	</body>
</html>
