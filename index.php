<?php
/*
 *
*/
get_header();

$title = get_theme_mod('pedigree-blog-title', __('Articulos Whiskas®', 'pedigree-genosha'));
$text = get_theme_mod('pedigree-blog-text', '');
?>
<!-- MAIN CONTENT -->
<div id="main-content">
    <div class="container archive-page">
    <?php if( have_posts() ): ?>
        <?php if( $title || $text ): ?>
        <div class="page-header">
            <?php if( $title ): ?>
            <h1 class="display-4 title"><?php echo $title; ?></h1>
            <?php endif; ?>
            <p class="description"><?php echo $text; ?></p>
        </div>
        <?php endif; ?>
        <div class="related-posts">
            <div class="row">
            <?php while ( have_posts() ) : the_post(); ?>
                <div class="col-sm-4 post-box">
                    <div class="post-thumbnail" style="background-image: url(<?php echo get_the_post_thumbnail_url($post, 'full'); ?>);"></div>
                    <div class="post-info">
                        <a href="<?php echo get_permalink(); ?>">
                            <h1 class="post-title"><?php the_title(); ?></h1>
                        </a>
                        <p class="post-excerpt"><?php echo get_the_excerpt(); ?></p>
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
