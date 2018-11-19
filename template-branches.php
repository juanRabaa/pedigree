<?php
/*
 *  Template Name: Sucursales
 *
*/
get_header();
?>
<!-- MAIN CONTENT -->
<div id="main-content" class="stores-main-content">
    <?php if(false): //Seccion de productos deprecada?>
    <!--PRODUCTS SECTION-->
    <div class="container archive-page">
    <?php
    $products_query = new WP_Query(array(
        'post_type'         => 'pedigree_product',
        'orderby'           => 'date',
    ));
    ?>
    <?php if( $products_query->have_posts() ): ?>
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
            <?php while ( $products_query->have_posts() ) : $products_query->the_post(); ?>
                <?php pedigree_product_prev_box( $post->ID, array('show_info_button'   => false)); ?>
            <?php endwhile; // end of the loop. ?>
            </div>
        </div>
        <?php wp_reset_postdata(); ?>
    <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- PURCHASE SECTION -->
    <?php $stores_links = pedigree_get_stores_links(); ?>
    <div id="purchase-options" class="container">
        <div class="row justify-content-center">
            <?php if( is_array($stores_links) && !empty($stores_links) ): ?>
            <!-- ONLINE SHOPS -->
            <div class="col-12 col-md-6 section-buy-online">
                <div class="sec-header">
                    <h2 class="title">Comprar Online</h2>
                       <p>Elegí una de las tiendas para comprar online</p>
                </div>
                <?php print_stores_logos( $stores_links ); ?>
            </div>
            <?php endif; ?>
            <!-- MAP -->
            <div class="col-12 col-md-6 section-map">
                <div class="sec-header"><h2 class="title">Comprar en Tiendas</h2></div>
                <div class="content">
                    <div id="stores-map-tools" class="side-by-side">
                        <div id="search-button" class="more-button pedigree-yellow-color full-width nowrap">
                            <input id="map-address-search" type="text" placeholder="INGRESA TU DIRECCIÓN..." autocomplete="off">
                            <i class="fas fa-search"></i>
                        </div>
                        <div id="geolocation-button" class="more-button pedigree-yellow-color full-width nowrap">
                            <span> DETECTAR TU UBICACIÓN </span>
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                    </div>
                    <div id="stores-map" src="https://lacasadelasospecha.files.wordpress.com/2013/02/imagen-11.png?w=748"></div>
                </div>
            </div>
        </div>
    </div>

</div>

<?php get_footer(); ?>
