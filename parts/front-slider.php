<?php
/*
*
*	Template for the featured post section of the front page
*
*/

// =============================================================================
// Cover info
// =============================================================================
$slides = json_decode(get_theme_mod('pedigree-slider-content', ''), true);
?>

<div class="sec slider home" data-type="homeSlider" id="slider-section">
	<?php if( isset($slides) && is_array($slides) ): ?>
	<div class="slides">
		<?php
		$is_first_slide = true;
			foreach($slides as $slide):
				$reverse_class = $slide['reverse'] ? '' : 'reverse';
				$active_class = $is_first_slide ? 'active' : '';
				$text_col_class = '';
				$img_col_class = '';
				$side_image_link = $slide['side_image_link'];
				$side_image_link_attr = $slide['side_image_link'] ? 'href="'.$slide['side_image_link'].'"' : '';
				$video_attr = '';
				$button_text = $slide['button_text'] ? $slide['button_text'] : 'MÁS INFO';

				if( !($slide['text'] || $slide['name']) && (!$slide['url'] || $slide['url'] ) )
					$text_col_class .= ' d-block d-sm-none';
				if( !$slide['side_image'] ){
					$img_col_class .= ' d-none';
					$text_col_class .= ' text-center';
				}
				if($slide['video_id'])
					$video_attr = 'data-url="'. $slide['video_id'] .'"';
		?>
		<div class="slide <?php echo $active_class; ?>" <?php echo $video_attr; ?> style="background-image: url(<?php echo $slide['background_image']?>);">
			<div class="container content <?php echo $reverse_class; ?>">
				<div class="row">
					<div class="text col-12 col-sm-8 <?php echo $text_col_class; ?>">
						<h1 class="display-3 title pedigree-main-color"><?php echo $slide['name']; ?></h1>
						<div class="slider-text">
							<p><?php echo $slide['text']; ?></p>
						</div>
						<div class="slide-side-image-mobile">
							<a <?php echo $side_image_link_attr; ?>><img src="<?php echo $slide['side_image']; ?>"></a>
						</div>
						<?php if($slide['url'] || $slide['video_id']): ?>
						<div class="more-button-container">
							<?php if($slide['video_id']): ?>
							<?php pedigree_more_button(array(
								'text'  	=> 'VER VIDEO',
								'faw'   	=> 'far fa-play-circle',
								'classes'	=> 'play-button whole',
							)); ?>
							<?php endif; ?>
							<?php if($slide['url']): ?>
							<?php pedigree_more_button(array(
								'text'  	=> $button_text,
								'url'		=> $slide['url'],
								'classes'	=> 'play-button whole',
							)); ?>
							<?php endif; ?>
						</div>
						<?php endif; ?>
					</div>
					<div class="image col-sm-4 <?php echo $img_col_class; ?>">
						<a <?php echo $side_image_link_attr; ?>><img src="<?php echo $slide['side_image']; ?>"></a>
					</div>
				</div>
			</div>
		</div>
		<?php
			$is_first_slide = false;
		endforeach;
		?>
	</div>
	<?php if( count($slides) > 1 ): ?>
	<div class="slides-pagination">
		<?php
		$is_first_bullet = true;
		foreach($slides as $slide):
			$active_class = $is_first_bullet ? 'active' : '';
		?>
		<span class="bullet <?php echo $active_class; ?>"></span>
		<?php
			$is_first_bullet = false;
		endforeach; ?>
	</div>
	<div class="container slider-controls">
		<div class="row">
			<div class="left-button">
				<i class="fas fa-angle-left"></i>
			</div>
			<div class="right-button">
				<i class="fas fa-angle-right"></i>
			</div>
		 </div>
	</div>
	<?php endif; ?>
	<div class="video-container">
		<div class="exit-button"><i class="fas fa-times"></i></div>
        <div id="slide-video"></div>
    </div>
<?php endif; ?>
</div>
