<div class="container">

    <div class="post">

        <?php if (isset($post->heroPhoto)) : ?>
            <hero-photo path="/<?php echo $post->category->slug . '/' . $post->slug . '/' . $post->heroPhoto; ?>"></hero-photo>
        <?php endif; ?>

        <hgroup>
            <h2><?php echo $post->title; ?></h2>
            <h4><?php echo date('l jS F Y', $post->written); ?></h4>
        </hgroup>

        <?php echo $post->html; ?>

    </div>

</div>
