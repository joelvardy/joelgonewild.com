<!DOCTYPE html>
<html>
	<head>
		<title>Travel Blog | Joel Vardy</title>
	</head>
	<body>

		<h1>Travel Blog</h1>

		<?php foreach ($categories as $category) : ?>

			<h2><?php echo $category->title; ?></h2>

			<?php foreach ($category->posts as $post) : ?>

				<h3><?php echo $post->title; ?></h3>

			<?php endforeach; ?>

		<?php endforeach; ?>

	</body>
</html>
