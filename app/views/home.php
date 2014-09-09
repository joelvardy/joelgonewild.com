<!DOCTYPE html>
<html>
	<head>
		<title>Travel Blog | Joel Vardy</title>
	</head>
	<body>

		<h1>Travel Blog</h1>

		<div class="posts">

			<?php foreach ($posts as $post) : ?>

				<h2><a href="/<?php echo $post->category->slug; ?>/<?php echo $post->slug; ?>" title="<?php echo $post->category->title; ?> full post"><?php echo $post->title; ?></a></h2>

			<?php endforeach; ?>

		</div>

		<ul class="categories">

			<?php foreach ($categories as $category) : ?>

				<li><a href="/category/<?php echo $category->slug; ?>" title="View posts from <?php echo $category->title; ?>"><?php echo $category->title; ?></a></li>

			<?php endforeach; ?>

		</ul>

	</body>
</html>
