<?php
/*
*
*	Template for the featured post section of the front page
*
*/
$title = get_theme_mod('pedigree-columns-section-2-title', '');
$columns = json_decode(get_theme_mod('pedigree-columns-section-2-content', ''), true);

?>

<div class="sec list" id="list-2-section">
	<?php if(isset($columns) && is_array($columns)): ?>
	<div class="center product">
		<div class="container">
			<div class="title">
				<h1 class="scr"><?php echo $title; ?></h1>
			</div>
			<div class="row products-list">
				<?php foreach($columns as $column): ?>
				<!-- PRODUCT BLOCK -->
				<div class="list-item col-12 col-sm-6 col-lg-3">
					<div class="product">
						<div class="title col-12">
							<h1 class="pedigree-main-color pedigree-light"><?php echo $column['name']; ?></h1>
						</div>
						<div class="image before col-12">
							<a href="<?php echo $column['url']; ?>">
								<img src="<?php echo $column['image']; ?>">
							</a>
						</div>
						<div class="button col-12">
							<?php pedigree_more_button(array(
								'text'  => 'MÁS INFO',
								'url'   => $column['url'],
							)); ?>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php endif; ?>
</div>
