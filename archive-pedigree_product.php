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
        <?php
        // =====================================================================
        // FILTERS
        // =====================================================================
        require_once get_template_directory() . '/inc/rb-wordpress-framework/filter/rb-filter.php';

        $pedigree_filter = pedigree_get_products_filter();
        $pedigree_filter->render();

        ?>
        <div class="related-posts products-list-boxes">
            <div class="row">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php pedigree_product_prev_box( $post->ID, array( 'show_buy_button' => false ) ); ?>
            <?php endwhile; // end of the loop. ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>
