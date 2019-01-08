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
	<!-- SECTION LIST -->
	<?php get_template_part("parts/front", "list-1"); ?>
	<!-- SECTION ARTICLE -->
	<?php if( PED_FEATURED_POST ) get_template_part("parts/front", "featured-post"); ?>
</div>
<?php get_footer(); ?>
