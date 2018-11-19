<?php
/*
 *
*/
get_header();
?>
<!-- MAIN CONTENT -->
<div id="main-content">
    <div class="container archive-page">
    <?php if( have_posts() ): ?>
        <div class="related-posts">
            <div class="row">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="col-sm-4 post-box">
                    <div class="post-thumbnail" style="background-image: url(<?php echo get_the_post_thumbnail_url($post, 'full'); ?>);"></div>
                    <div class="post-info">
                        <h1 class="post-title"><?php the_title(); ?></h1>
                        <p class="post-excerpt"><?php the_excerpt(); ?></p>
                    </div>
                    <?php pedigree_more_button(array(
                        'text'  => 'Leer artículo',
                        'url'   => get_permalink(),
                    )); ?>
                </div>
            <?php endwhile; // end of the loop. ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>
