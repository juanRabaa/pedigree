<?php
/*
*	Template Name: Home Page
* 	Template Post Type: post, page
*/
get_header();
?>
<!-- MAIN CONTENT -->
<div id="main-content">
    <!-- SECTION SLIDER -->
	<?php get_template_part("parts/front", "slider"); ?>
    <!-- SECTION TEASER -->
    <!-- <div class="sec teaser teaser1">
        <div class="container">
            <div class="center">
                <div class="row">
                    <div class="left before col-12 col-sm-5">
                        <div class="inline-block">
                            <h1>PEDIGREE® Vital Pro Raças Pequenas</h1>
                            <p>O novo PEDIGREE® Vital Pro para Raças Pequenas é feito especialmente para suprir as necessidades específicas de cães de pequeno porte. </p>
                        </div>
                    </div>
                    <div class="middle d-none d-sm-none d-md-block before col-sm-2">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/banner/bnnr4-bg.png">
                    </div>
                    <div class="right before col-12 col-sm-5">
                        <div class="more-button white">
                            <a href="produtos/adultos/pedigree-vital-pro-adulto-racas-pequenas-1kg.html"></a>
                        	<span> MÁS INFO </span>
                            <i class="fas fa-caret-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

	<!-- SECTION LIST -->
	<?php get_template_part("parts/front", "list-1"); ?>
	<!-- SECTION ARTICLE -->
	<?php if( PED_FEATURED_POST ) get_template_part("parts/front", "featured-post"); ?>
	<!-- SECTION LIST -->
	<?php get_template_part("parts/front", "list-2"); ?>

</div>
<?php get_footer(); ?>
