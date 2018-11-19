<?php
/*
*
*
*/
?>
<div id="footer">
    <!-- SECTION SEPARATOR -->
    <?php $footer_image = get_theme_mod('pedigree-footer-image', ''); ?>
    <?php if( $footer_image && !$hide_separator ): ?>
    <div class="sec separator">
        <div class="separator-image" style="background-image: url(<?php echo $footer_image; ?>"></div>
    </div>
    <?php endif; ?>
    <div class="sec footer-top">
        <div class="container">
            <div class="center">
                <div class="row">
                    <div class="menu2 col-12 col-sm-9  col-md-10">
                        <div class="row footer-row">
                            <?php
                            $menu_items = get_menu_items_by_registered_slug('footer_menu');
                            foreach($menu_items as $item): ?>
                            <ul class="col-12 col-sm-auto">
                                <li><a class="first subfooter" href="<?php echo $item->url; ?>" title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a></li>
                                <?php foreach($item->childrens as $children): ?>
                                <li><a href="<?php echo $children->url; ?>" title="<?php echo $children->title; ?>"><?php echo $children->title; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php endforeach; ?>

                        </div>
                    </div>
                    <div class="toparea col-12 col-sm-3 col-md-2">
                        <?php get_template_part('parts/part', 'social-list'); ?>
                    </div>
                    <div class="logo col-12">
                        <a href="<?php echo get_home_url(); ?>" title="Home">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="Logo">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php
	$text = get_theme_mod('pedigree-footer-text', '');
	$links = json_decode(get_theme_mod('pedigree-footer-links', ''), true);
	?>
     <div class="sec footer-bottom">
        <div class="container">
            <div class="center">
                <div class="row">
                    <div class="left col-12 col-sm-6 col-md-7"><?php echo $text; ?></div>
                    <div class="right col-12 col-sm-6 col-md-5">
                        <ul class="list-unstyled">
							<?php if(isset($links) && is_array($links)): foreach($links as $link): ?>
                            <li><a href="<?php echo $link['url']; ?>" target="_blank"><?php echo $link['text']; ?></a></li>
							<?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
