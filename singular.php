<?php
/*
 *
 *
*/
get_header();
?>
<!-- MAIN CONTENT -->
<div id="main-content">
    <div class="container post-page">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="post-featured-image" style="background-image: url(<?php the_post_thumbnail_url('full'); ?>);"></div>
        <div class="post-content-box">
            <h1 class="display-4 post-title pedigree-main-color"><?php the_title(); ?></h1>
            <div class="post-content">
        	     <?php echo the_content(); ?>
            </div>
        </div>
        <?php
        $related_posts = get_related_posts($post, 3);
        if($related_posts):?>
        <div class="related-posts">
            <div class="row">
            <?php foreach($related_posts as $related_post): ?>
                <div class="col-sm-4 post-box">
                    <div class="post-thumbnail" style="background-image: url(<?php echo get_the_post_thumbnail_url($related_post, 'full'); ?>);"></div>
                    <div class="post-info">
                        <h1 class="post-title"><?php echo $related_post->post_title; ?></h1>
                        <p class="post-excerpt"><?php echo get_the_excerpt( $related_post ); ?></p>
                    </div>
                    <?php pedigree_more_button(array(
                        'text'  => 'Leer artículo',
                        'url'   => get_permalink($related_post),
                    )); ?>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    <?php endwhile; // end of the loop. ?>
    </div>
</div>
<?php get_footer(); ?>
