<?php
/*
*
*	Template for the featured post section of the front page
*
*/
?>

<?php
for( $i = 1; $i <= PED_FIRST_LINK_SEC_ROWS_AMOUNTS; $i++):
	$title = get_theme_mod("pedigree-columns-section-$i-title", '');
	$columns = json_decode(get_theme_mod("pedigree-columns-section-$i-content", null), true);
	$isvalid = isset($columns) && is_array($columns);
	$section_class = $isvalid ? "" : "d-none";
?>
	<div class="sec list <?php echo $section_class; ?>" id="list-<?php echo $i; ?>-section">
		<?php if( isset($columns) && is_array($columns) ): ?>
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
								<h1 class="pedigree-main-color"><?php echo $column['name']; ?></h1>
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
<?php endfor; ?>
