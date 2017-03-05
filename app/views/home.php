<div class="container sidebar">

    <section class="posts">
        <?php foreach ($posts as $post) : ?>

            <article class="post">

                <?php if (isset($post->heroPhoto)) : ?>
                    <hero-photo path="/<?php echo $post->category->slug . '/' . $post->slug . '/' . $post->heroPhoto; ?>" link="/<?php echo $post->category->slug; ?>/<?php echo $post->slug; ?>"></hero-photo>
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

        <biography></biography>

        <categories></categories>

    </aside>

</div>
