<?php
/*
 *
 *
*/
get_header();
?>
<!-- MAIN CONTENT -->
<div id="main-content">
    <?php while ( have_posts() ) : the_post(); ?>
    <div class="pedigree-product container">
        <div class="row align-items-start">
        	<div class="container product-header col-12 col-md-4">
                <img class="product-image" src="<?php the_post_thumbnail_url('full'); ?>">
                <div class="bottom">
                    <h1 class="product-title pedigree-yellow-color"><?php the_title(); ?></h1>
                    <?php if( PEDIGREE_STORES_ACTIVATED ): ?>
                        <?php $branches_page = json_decode(get_theme_mod('pedigree-branches-page', ''), true); ?>
                        <?php if(is_array($branches_page) && isset($branches_page['page_id']) && $branches_page['page_id'] != -1): ?>
                        <div class="buy-button">
                            <?php pedigree_more_button(array(
                                'text'  => 'COMPRAR',
                                'url'	=> get_permalink($branches_page['page_id']),
                                'icon'  => false,
                            )); ?>
                        </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="product-table col-12 col-md-8">
                <h1 class="product-title pedigree-yellow-color display-4"><?php the_title(); ?></h1>
                <ul class="triggers">
                    <li de data-content="<?php echo esc_attr(get_the_content()); ?>" class="container trigger active">Descripción</li>
                    <li data-content="<?php echo esc_attr(get_post_meta( $post->ID, 'pedigree_product_ingredients', true )); ?>"  class="container trigger">Ingredientes</li>
                    <li data-content="<?php echo esc_attr(get_post_meta( $post->ID, 'pedigree_product_guide', true )); ?>"  class="container trigger">Guía de alimentación</li>
                    <li data-content="<?php echo esc_attr(get_product_characteristics_ul( $post->ID )); ?>"  class="container trigger">Características</li>
                </ul>
                <div class="container content"><?php the_content(); ?></div>
            </div>
        </div>
    </div>

    <?php if( PEDIGREE_STORES_ACTIVATED ): ?>
    <!-- OPCIONES DE COMPRA -->
    <?php
        $stores = get_post_meta( $post->ID, 'pedigree_product_stores', true );
        $stores = is_string($stores) ? json_decode($stores, true) : null;
    ?>
    <div id="purchase-options" class="container">
        <div class="row justify-content-center">
            <?php if( is_array($stores) && !empty($stores) ): ?>
            <!-- ONLINE SHOPS -->
            <div class="col-12 col-md-6 section-buy-online">
                <div class="sec-header">
                    <h2 class="title">Comprar Online</h2>
                       <p>Elegí una de las tiendas para comprar online este producto PEDIGREE</p>
                </div>
                <?php print_stores_logos( $stores ); ?>
            </div>
            <?php endif; ?>
            <!-- MAP -->
            <div class="col-12 col-md-6 section-map">
                <div class="sec-header"><h2 class="title">Comprar en Tiendas</h2></div>
                <div class="content">
                    <div id="stores-map-tools" class="side-by-side">
                        <?php pedigree_more_button(array(
                            'content'   => "<input id='map-address-search' type='text' placeholder='INGRESA TU DIRECCIÓN...' autocomplete='off'>",
                            'classes'	=> 'full-width nowrap',
                            'id'        => 'search-button',
                            'faw'       => 'fas fa-search',
                        )); ?>
                        <?php pedigree_more_button(array(
                            'text'  	=> 'DETECTAR TU UBICACIÓN',
                            'classes'	=> 'full-width nowrap',
                            'id'        => 'geolocation-button',
                            'faw'       => 'fas fa-map-marker-alt',
                        )); ?>
                    </div>
                    <div id="stores-map" src="https://lacasadelasospecha.files.wordpress.com/2013/02/imagen-11.png?w=748"></div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php endwhile; // end of the loop. ?>
</div>
<?php get_footer(); ?>
