<?php
/*
*
*	Header template
*
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width"/>
	<title><?php echo get_bloginfo( "name" ); ?></title>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>">
</head>
<?php //print_r(get_menu_items_by_registered_slug('header_menu')); ?>
<body>
	<!-- NAVBAR -->
	<div class="header-placeholder"></div>
    <div class="header">
        <div class="container">
            <div class="row">
		    	<div class="logo before d-none d-sm-none d-md-none d-lg-block col-2">
		            <a href="<?php echo get_home_url(); ?>" title="Home">
		                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="Logo">
		            </a>
		        </div>
                <!-- MENU -->
                <div class="menu before col-4 col-lg-8">
                    <span class="menu-icon  d-lg-none before" title="Menu">Menu</span>
					<div class="menu-content">
	                <ul class="main">
						<?php
							$menu_items = get_menu_items_by_registered_slug('header_menu');
							foreach($menu_items as $item):
								$has_childrens = isset($item->childrens) && isset($item->childrens[0]);
								$href_attr = $item->url ? 'href="'.$item->url.'"' : '';
								if(!$has_childrens):
								?>
								<li>
									<div class="menu-item-title">
										<a class="home-navi" <?php echo $href_attr; ?> title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a>
									</div>
								</li>
							<?php else: ?>
								<li class="submenu-button">
									<div class="menu-item-title">
				                        <a class="product-navi" <?php echo $href_attr; ?> title="<?php echo $item->title; ?>"><?php echo $item->title; ?></a>
				                        <div class="down-button"><i class="fas fa-sort-down"></i></div>
									</div>
			                        <ul class="menu-sub">
										<?php foreach($item->childrens as $sub_item): ?>
											<?php $href_attr = $sub_item->url ? 'href="'.$sub_item->url.'"' : ''; ?>
			                            	<li><a <?php echo $href_attr; ?>><?php echo $sub_item->title; ?></a></li>
										<?php endforeach; ?>
			                        </ul>
			                    </li>
							<?php endif;
							endforeach;
						?>
	                </ul>
	                <div class="mobile-toparea d-lg-none d-xl-none">
						<?php get_template_part('parts/part', 'social-list'); ?>
	                </div>
	            </div>
                </div>
                <!-- LOGO -->
                <div class="logo d-lg-none col-4">
                    <a href="<?php echo get_home_url(); ?>" title="Home">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png" alt="Logo">
                    </a>
                </div>
   				<div class="toparea before d-none d-sm-none d-md-none  d-lg-block col-sm-2">
            		<?php get_template_part('parts/part', 'social-list'); ?>
				</div>
            </div>
        </div>
    </div>
