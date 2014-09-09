<!DOCTYPE html>
<html>
	<head>
		<title>Travel Blog | Joel Vardy</title>
	</head>
	<body>

		<h1>Travel Blog</h1>

		<?php foreach ($posts as $post) : ?>

			<h2><?php echo $post->title; ?></h2>

		<?php endforeach; ?>

	</body>
</html>
