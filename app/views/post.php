<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $post->title; ?> | Travel Blog | Joel Vardy</title>
        <meta name="description" content="<?php echo $post->description; ?>">
        <meta property="og:title" content="<?php echo $post->title; ?> with Joel">
        <meta property="og:type" content="article">
        <meta property="og:image" content="https://joelgonewild.com/<?php echo $post->category->slug.'/'.$post->slug.'/'.$post->heroPhoto; ?>/600.jpg">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php echo $post->title; ?> with Joel">
        <meta name="twitter:creator" content="@joelvardy">
        <meta name="twitter:image" content="https://joelgonewild.com/<?php echo $post->category->slug.'/'.$post->slug.'/'.$post->heroPhoto; ?>/600.jpg">
        <script src="//use.typekit.net/pel3gnp.js"></script>
        <script>
            try {
                Typekit.load();
            } catch (e) {}
        </script>
        <link rel="stylesheet" href="/assets/css/design.css">
    </head>
    <body>

        <header>
            <a href="/" title="List of posts">
                <img src="/assets/img/icon.svg">
                <h1>Travel Blog</h1>
            </a>
        </header>

        <div class="container">

            <div class="post">

                <?php if (isset($post->heroPhoto)) : ?>
                    <div class="photo hero hero-post" data-path="/<?php echo $post->category->slug.'/'.$post->slug.'/'.$post->heroPhoto; ?>"></div>
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
