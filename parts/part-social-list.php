<?php
/*
*
*
*/

$social_list = json_decode(get_theme_mod('pedigree-social-networks', ''), true);
?>
<ul class="social pedigree-social-list">
	<?php if(isset($social_list) && is_array($social_list)): ?>
		<?php foreach($social_list as $list_item): ?>
		<li>
			<span title="<?php echo $list_item['name']; ?>" class="fa-stack fa-2x">
				<i class="fa fa-circle fa-stack-2x icon-background1"></i>
				<i class="fab <?php echo $list_item['fa']; ?> fa-stack-1x"></i>
				<a target="_blank" href="<?php echo $list_item['url']; ?>"></a>
			</span>
		</li>
		<?php endforeach; ?>
	<?php endif; ?>
</ul>
