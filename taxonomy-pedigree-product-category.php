<?php
/*
 *
*/
get_header();
?>
<!-- MAIN CONTENT -->
<div id="main-content">
    <div class="sec separator category-header">
        <?php
            $cat_id = get_queried_object()->term_id;
            $cat_images_ids = pedigree_products_cat_images($cat_id);
            $separator_image = '';
            $separator_style = '';
            if(is_array($cat_images_ids) && isset($cat_images_ids[0])){
                $separator_image = wp_get_attachment_image_src( $cat_images_ids[0], 'full' )[0];
                $separator_style = 'style="background-image: url('. $separator_image .')"';
            }
            $col_size = pedigree_products_cat_col_size($cat_id);
        ?>
        <div class="separator-image" <?php echo $separator_style; ?>>
            <div class="category-info-container container">
                <div class="row align-items-center">
                    <div class="col-3 col-sm-6 col-md-6"></div>
                    <div class="col-9 col-sm-6 col-md-6 category-info">
                        <h1 class="title"><?php echo single_term_title(); ?></h1>
                        <p class="description"><?php echo term_description(); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container archive-page">
    <?php if( have_posts() ): ?>
        <div class="related-posts products-list-boxes">
            <div class="row">
            <?php while ( have_posts() ) : the_post(); ?>
                <?php pedigree_product_prev_box( $post->ID, array( 'show_buy_button' => false, 'col_size' => $col_size ) ); ?>
            <?php endwhile; // end of the loop. ?>
            </div>
        </div>
    <?php endif; ?>
    </div>
</div>
<?php get_footer(); ?>
