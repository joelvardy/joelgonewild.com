<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo $page_title; ?></title>
        <meta name="description" content="<?php echo $page_description; ?>">
        <meta property="og:title" content="<?php echo $og_title; ?>">
        <meta property="og:type" content="website">
        <meta property="og:image" content="<?php echo $og_image; ?>">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php echo $og_title; ?>">
        <meta name="twitter:creator" content="@joelvardy">
        <meta name="twitter:image" content="<?php echo $og_image; ?>">
        <link rel="stylesheet" href="/css/app.css">
        <script src="//use.typekit.net/pel3gnp.js"></script>
        <script>
            try {
                Typekit.load();
            } catch (e) {}
        </script>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
            })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
            ga('create', 'UA-65769078-1', 'auto');
            ga('send', 'pageview');
        </script>
    </head>
    <body>
        <div id="app">

            <header>
                <a href="/" title="List of posts">
                    <img src="/img/icon.svg">
                    <h1>Travel Blog</h1>
                </a>
            </header>

            <?php echo $content; ?>

        </div>
        <script src="/js/app.js"></script>
    </body>
</html>
