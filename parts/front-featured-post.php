<?php
/*
*
*	Template for the featured post section of the front page
*
*/

// =============================================================================
// Cover info
// =============================================================================
$cover_info = json_decode(get_theme_mod('pedigree-featured-post-info', ''), true);
$cover_post = pedigree_get_featured_post();

$href_attr = "";
if($cover_post){
	$link = $cover_post ? $cover_post->guid : "";
	$href_attr = "href='$link'";
}
if( $cover_info["use_post_data"] && $cover_post){
	$image_src = get_the_post_thumbnail_url( $cover_post, 'full' );
	$title = $cover_post->post_title;
	$text = wp_trim_words($cover_post->post_content, 25);
}
else{
	$image_src = $cover_info["image"];
	$title = $cover_info["title"];
	$text = $cover_info["text"];
}
?>

<div class="sec article" id="featured-post-section">
	<div class="title container">
		<h1 class="scr">Artículos Whiskas®</h1>
	</div>
	<div class="article-image" style="background-image: url(<?php echo $image_src; ?>);"></div>
	<div class="container post-info-container">
			<!-- <p class="img-cred">img: credito img</p> -->
			<h1 class="post-title"><?php echo $title; ?></h1>
			<p class="post-excerpt"><?php echo $text; ?></p>
			<?php pedigree_more_button(array(
				'text'  => 'Leer artículo',
				'url'   => $href_attr,
			)); ?>
	</div>
</div>
