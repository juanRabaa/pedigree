<?php
require get_template_directory() . '/theme-config.php';

add_theme_support( 'post-thumbnails' );
add_post_type_support( 'page', 'excerpt' );

register_nav_menu( 'header_menu', __( 'Header menu', 'pedigree-genosha' ) );
register_nav_menu( 'footer_menu', __( 'Footer menu', 'pedigree-genosha' ) );

/*STYLES*/
/*************************************************************************************************/
function pedigree_load_styles() {
	wp_enqueue_style( "font-awesome-css", "https://use.fontawesome.com/releases/v5.1.0/css/all.css", array() );
	wp_enqueue_style( "bootstrap-cc", get_template_directory_uri()."/css/libs/bootstrap-4.1.3-dist/bootstrap.min.css?ver=4.9.8", array() );
	wp_enqueue_style( "animate-css", get_template_directory_uri()."/css/libs/animate.css", array() );
}
add_action ("wp_enqueue_scripts", "pedigree_load_styles");

/*SCRIPTS*/
/*************************************************************************************************/
function pedigree_load_scripts() {
	wp_enqueue_script( "jquery-3", "https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js", true );
	wp_enqueue_script( "bootstrap-js", get_template_directory_uri()."/js/libs/bootstrap-4.1.3-dist/bootstrap.min.js", true );
	wp_enqueue_script( "pedigree-menu", get_template_directory_uri()."/js/src/pedigree-menu.js", true );
	wp_enqueue_script( "pedigree-products", get_template_directory_uri()."/js/src/pedigree-products.js", true );
	wp_enqueue_script( "rb-collapsible", get_template_directory_uri()."/js/src/rb-collapsible.js", true );
	wp_enqueue_script( "rb-filter", get_template_directory_uri()."/js/src/rb-filter.js", true );

	if(is_page_template('template-branches.php') || is_singular( 'pedigree_product' )){
		//MAP
		wp_enqueue_script( "pedigree-places-map", get_template_directory_uri()."/js/src/pedigree-places-map.js", true );
		wp_localize_script( "pedigree-places-map", 'wp_data', array(
			'places'		=> predigree_get_places(),
			'markerIcon'	=> get_template_directory_uri() . '/assets/img/marker-icon-2.png',
		));
		wp_enqueue_script( "pedigree-purchase-section-script", get_template_directory_uri()."/js/src/pedigree-purchase-template-script.js", true );
	}

	if(is_page_template('template-nuevo-local.php')){
		//FORM JAVASCRIPT
		wp_enqueue_script( "pedigree-new-local-form", get_template_directory_uri()."/js/src/pedigree-new-local-form.js", true );
		wp_localize_script( "pedigree-new-local-form", 'wp_data', array(
			'ajaxurl'	=> admin_url( 'admin-ajax.php' ),
		));
	}

	if(is_front_page() ){
		wp_enqueue_script( "hammer-js", get_template_directory_uri()."/js/libs/hammer.js", true );
		wp_enqueue_script( "pedigree-slider", get_template_directory_uri()."/js/src/pedigree-slider.js", array("hammer-js"), true );
		wp_enqueue_script( "youtube-api", get_template_directory_uri()."/js/libs/youtube-api.min.js", true );
	}
}
add_action ("wp_enqueue_scripts", "pedigree_load_scripts");

function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

if( !PEDIGREE_STORES_ACTIVATED ){
	add_filter( 'theme_page_templates', function( $page_templates ){
		unset( $page_templates['template-branches.php'] );
		return $page_templates;
	});
}

if( !PED_NEW_LOCAL_FORM ){
	add_filter( 'theme_page_templates', function($page_templates){
		unset( $page_templates['template-nuevo-local.php'] );
		return $page_templates;
	});
}
else{
	require_once get_template_directory() . '/inc/new-local-form-handler.php';

	add_filter( 'page_template', 'single_page_template' );
	function single_page_template( $template ){
		$form_page_id = get_theme_mod('pedigree-add-store-page', -1);
		$current_page_id = get_queried_object_id();
		if( $current_page_id == $form_page_id ) {
			$template =  get_stylesheet_directory() . '/template-nuevo-local.php';
		}
		return $template;
	}
}

// =============================================================================
// MARKUP
// =============================================================================
function pedigree_more_button($args){
	$defaults = array(
		'text'			=> '',
		'content'		=> '',
		'url'			=> '',
		'icon'			=> true,
		'faw'			=> 'fas fa-caret-right',
		'classes'		=> '',
		'id'			=> '',
		'attrs'			=> array(),
		'element'		=> 'div',
	);
	$settings = wp_parse_args($args, $defaults);
	extract($settings);
	if($text || $content):
		$id_attr = $id ? "id=$id" : '';

	$html_attrs = '';
	if(is_array($attrs) && !empty($attrs)){
		foreach($attrs as $attr_name => $attr_val){
			if( $attr_name != 'class' && $attr_name != 'id' ){
				$html_attrs .= esc_html($attr_name) . '="' . esc_attr($attr_val) . '" ';
			}
		}
	}

	?>
	<<?php echo $element;?> <?php echo $id_attr; ?> class="more-button pedigree-main-color <?php echo esc_attr($classes); ?>" <?php echo $html_attrs; ?>>
		<?php if( $url ): ?><a href="<?php echo esc_attr($url); ?>"></a><?php endif; ?>
		<?php if( $content ): echo $content; ?>
		<?php else: ?>
		<span><?php echo $text; ?></span>
		<?php endif; ?>
		<?php if( $icon ): ?>
		<i class="<?php echo esc_attr($faw); ?>"></i>
		<?php endif; ?>
	</<?php echo $element;?>>
	<?php
	endif;
}

function pedigree_product_prev_box( $product_ID, $args = array() ){
	$peaces_images = pedigree_get_product_peaces_images($product_ID);

	$categories = get_the_terms($product_ID, 'pedigree-product-category');
	$categories_ids = is_array($categories) ? array_map(function($c){ return $c->term_id; }, $categories) : array();

	$settings = array(
		'title'				=> get_the_title($product_ID),
		'permalink'			=> get_permalink($product_ID),
		'img_src'			=> get_the_post_thumbnail_url($product_ID, 'full'),
		'peaces_images'		=> $peaces_images,
		'cats_ids'			=> $categories_ids,
		'show_info_button'	=> true,
		'show_buy_button'	=> true,
		'info_text'			=>	__('MÁS INFO', 'pedigree-genosha'),
		'buy_text'			=>	__('COMPRAR', 'pedigree-genosha'),
		'col_size'			=> 4,
		'url_params'		=> '',
	);
	$settings = wp_parse_args( $args, $settings );
	$settings['permalink'] .= $settings['url_params'];
	extract($settings);

	$size_class = ($col_size >= 1 && $col_size <= 12) ? "col-md-$col_size" : "col-md-4";
	?>
	<div class="col-12 col-sm-6 <?php echo $size_class; ?> post-box" data-cats="<?php echo esc_attr(json_encode($cats_ids)); ?>">
		<div class="product-image" data-images="<?php echo esc_attr(json_encode($peaces_images)); ?>">
			<a href="<?php echo $permalink; ?>">
				<img class="hover-twinkle" src="<?php echo $img_src; ?>"/>
			</a>
		</div>
		<div class="post-info">
			<a href="<?php echo $permalink; ?>">
				<h1 class="post-title"><?php echo $title; ?></h1>
			</a>
			<div class="info">
				<div class="buttons">
					<?php if($show_info_button): ?>
						<div class="more-button pedigree-main-color">
							<a href="<?php echo $permalink; ?>"></a>
							<span><?php echo $info_text; ?></span>
							<i class="fas fa-caret-right"></i>
						</div>
					<?php endif; ?>
					<?php if($show_buy_button): ?>
						<?php $branches_page = json_decode(get_theme_mod('pedigree-branches-page', ''), true); ?>
						<?php if(is_array($branches_page) && isset($branches_page['page_id']) && $branches_page['page_id'] != -1): ?>
						<div class="more-button pedigree-main-color">
							<a href="<?php echo get_permalink($branches_page['page_id']); ?>"></a>
							<span><?php echo $buy_text; ?></span>
							<i class="fas fa-caret-right"></i>
						</div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
}

// =============================================================================
// PRODUCTS FUNCTIONS
// =============================================================================
function pedigree_get_product_peaces_images($prod_ID){
	$images_ids = get_post_meta($prod_ID, 'pedigree_product_images', true);
	$images_url = array();
	if($images_ids){
		$images_ids = explode(',', $images_ids);
		foreach( $images_ids as $image_id ){
			$images_url[] = wp_get_attachment_url( $image_id );
		}
	}
	return $images_url;
}

function get_product_characteristics( $post_id ){
	$characteristics = array();
	if($post_id){
		$value = get_post_meta( $post_id, 'pedigree_product_characteristics', true );
		$characteristics = json_decode($value, true);
	}
	return $characteristics;
}

function get_product_characteristics_ul( $post_id ){
	$characteristics = get_product_characteristics( $post_id );
	$ul = "";

	if(isset($characteristics)):
		ob_start();
	?>
		<ul class="product-characteristics">
			<?php foreach($characteristics as $item): ?>
			<li class="row no-gutters">
				<div class="col-9 name"> <span><?php echo $item['name']; ?></span> </div>
				<div class="col-3 value"> <span><?php echo $item['value']; ?></span> </div>
			</li>
			<?php endforeach; ?>
		</ul>
	<?php
		$ul = esc_attr(ob_get_clean());
	endif;

	return $ul;
}

function pd_get_query_cats(){
	return isset($_GET['prod_cat']) ? explode(',', $_GET['prod_cat']) : null;
}

function pd_get_product_guide($post_id){
	$final_guide = '';
	$general_guide = get_post_meta( $post_id, 'pedigree_product_guide', true );
	$puppy_guide = get_post_meta( $post_id, 'pedigree_product_guide_puppy', true );
	$adult_guide = get_post_meta( $post_id, 'pedigree_product_guide_adult', true );
	$senior_guide = get_post_meta( $post_id, 'pedigree_product_guide_senior', true );

	$age_filter_cats = json_decode(get_theme_mod('pedigree-age-filter', ''), true);
	$prod_cat_filter = pd_get_query_cats();
	$puppy_included = $adult_included = $senior_included = false;
	$matched_filters = 0;

	if(is_array($prod_cat_filter) && !empty($prod_cat_filter)){
		foreach($prod_cat_filter as $cat_filter){
			if(!$puppy_included && $cat_filter == $age_filter_cats['puppy']){
				$final_guide .= $puppy_guide;
				$puppy_included = true;
				$matched_filters++;
			}
			if(!$adult_included && $cat_filter == $age_filter_cats['adult']){
				$final_guide .= $adult_guide;
				$adult_included = true;
				$matched_filters++;
			}
			if(!$senior_included && $cat_filter == $age_filter_cats['senior']){
				$final_guide .= $senior_guide;
				$senior_included = true;
				$matched_filters++;
			}

			if($puppy_guide && $adult_guide && $senior_included)
				break;
		}
	}

	//No hay descripciones o se paso mas de un filtro de edad
	if(!$final_guide || ($matched_filters > 1)){
		if($general_guide)//Hay guia general
			$final_guide = $general_guide;
		else if(!$final_guide){//No hay general y no habia guias para las categorias del filtro
			if($puppy_guide)
				$final_guide .= "$puppy_guide<br>";
			if($adult_guide)
				$final_guide .= "$adult_guide<br>";
			if($senior_guide)
				$final_guide .= "$senior_guide";
		}
	}

	return $final_guide;
}

function pd_get_product_description($post_id){
	$final_description = '';
	$general_description = apply_filters('the_content', get_post_field('post_content', $post_id));
	$puppy_description = get_post_meta( $post_id, 'pedigree_product_description_puppy', true );
	$adult_description = get_post_meta( $post_id, 'pedigree_product_description_adult', true );
	$senior_description = get_post_meta( $post_id, 'pedigree_product_description_senior', true );

	$age_filter_cats = json_decode(get_theme_mod('pedigree-age-filter', ''), true);
	$prod_cat_filter = pd_get_query_cats();
	$puppy_included = $adult_included = $senior_included = false;
	$matched_filters = 0;

	if(is_array($prod_cat_filter) && !empty($prod_cat_filter)){
		foreach($prod_cat_filter as $cat_filter){
			if(!$puppy_included && $cat_filter == $age_filter_cats['puppy']){
				$final_description .= $puppy_description;
				$puppy_included = true;
				$matched_filters++;
			}
			if(!$adult_included && $cat_filter == $age_filter_cats['adult']){
				$final_description .= $adult_description;
				$adult_included = true;
				$matched_filters++;
			}
			if(!$senior_included && $cat_filter == $age_filter_cats['senior']){
				$final_description .= $senior_description;
				$senior_included = true;
				$matched_filters++;
			}

			if($matched_filters > 1)
				break;
		}
	}

	//No hay descripciones o se paso mas de un filtro de edad
	if(!$final_description || ($matched_filters > 1)){
		if($general_description)
			$final_description = $general_description;
		else //Si no hay general, o habia mas de un filtro, mostramos solo el de adulto
			$final_description = $adult_description;
	}

	return $final_description;
}

// =============================================================================
// SUCURSALES
// =============================================================================
function sanitaze_csv_value( $value ){
	$value = $value != 'null' ? $value : null;
	return esc_attr($value);
}

function get_clean_branch_row_data( $csv_row ){
	$data = str_getcsv($csv_row);
	$clean_array = array(
		'sucursal'		=>	sanitaze_csv_value($data[1]),
		'address'		=>	sanitaze_csv_value($data[2]),
		'localidad'		=>	sanitaze_csv_value($data[4]),
		'prov'			=>	sanitaze_csv_value($data[5]),
		'name'			=>	sanitaze_csv_value($data[6]),
		'lat'			=>	floatval( sanitaze_csv_value( str_replace(',', '.', $data[7]) ) ),
		'lng'			=>	floatval( sanitaze_csv_value( str_replace(',', '.', $data[8]) ) ),
		'url'			=>	sanitaze_csv_value($data[9]),
		'phone'			=>	sanitaze_csv_value($data[10]),
		'timetable'		=>	sanitaze_csv_value($data[11]),
		'email'			=>	sanitaze_csv_value($data[12]),
	);

	return $clean_array;
}

function get_place_data_attributes( $place_data ){
	$final_attributes =
		'data-sucursal="'. $place_data['sucursal'] .'" ' .
		'data-address="'. $place_data['address'] .'" ' .
		'data-localidad="'. $place_data['localidad'] .'" ' .
		'data-prov="'. $place_data['prov'] .'" ' .
		'data-name="'. $place_data['name'] .'" ' .
		'data-lat="'. $place_data['lat'] .'" ' .
		'data-lng="'. $place_data['long'] .'" ' .
		'data-url="'. $place_data['url'] .'" ' .
		'data-phone="'. $place_data['phone'] .'" ' .
		'data-timetable="'. $place_data['timetable'] .'" ' .
		'data-email="'. $place_data['email'] .'" '
	;
	return $final_attributes;
}

function predigree_get_places(){
	$locales_posts = get_posts(array(
		'numberposts'	=> -1,
		'post_type'		=> 'pedigree-local',
		'post_status'   => 'publish',
	));

	$places = array();
	if( is_array($locales_posts) ){
		foreach( $locales_posts as $local_post ){
			$local_data = get_post_meta( $local_post->ID, 'pedigree_local_data', true );
			$local_geo = get_post_meta( $local_post->ID, 'pedigree_local_geolocation', true );
			$terms = get_the_terms( $local_post->ID, 'pedigree-fantasy-name' );
			$fantasia_term = is_array($terms) ? $terms[0] : null;
			$url = $fantasia_term ? get_term_meta( $fantasia_term->term_id, '_pd_fantasy_name_web', true ) : '';

			if( $local_data && $local_geo ){
				$map_data = array(
					'sucursal'		=>	$local_data['sucursal'],
					'address'		=>	$local_data['address'],
					'localidad'		=>	$local_data['localidad'],
					'prov'			=>	$local_data['provincia'],
					'name'			=>	$local_post->post_title,
					'lat'			=>	$local_geo['lat'],
					'lng'			=>	$local_geo['long'],
					'url'			=>	$url,
					'phone'			=>	$local_data['phone'],
					'timetable'		=>  $local_data['timetable'],
					'email'			=>	$local_data['email'],
				);

				array_push($places, $map_data);
			}
		}
	}

	return $places;
}

function pd_create_locales_from_options_csv(){
	$csv_attachment_url = get_theme_mod('pedigree-branches-csv', '');
	$csv_attachment_id = rb_get_attachment_id($csv_attachment_url);
	$csv_attachment_path = get_attached_file( $csv_attachment_id );
	pd_create_locales_from_csv($csv_attachment_path);
}

if( is_admin() ){
	// add_action('init', 'pd_delete_all_locales_data');
	// add_action('init', 'pd_create_locales_from_options_csv');
}

// =============================================================================
// PRODUCTS FILTERS
// =============================================================================

//Necesita que este cargado rb-filter.php
function pedigree_get_products_filter(){
	$filters = array();

	// =====================================================================
	// FOOD TYPE FILTERS
	// =====================================================================
	$food_type_cats = json_decode(get_theme_mod('pedigree-food-type-filter', ''), true);

	if( is_array($food_type_cats) && !empty($food_type_cats) ){
		$food_options = array();
		if( $food_type_cats['dry'] )
			array_push($food_options, array( 'value' => $food_type_cats['dry'], 'title' => 'Seco' ));
		if( $food_type_cats['moist'] )
			array_push($food_options, array( 'value' => $food_type_cats['moist'], 'title' => 'Húmedo' ));
		if( $food_type_cats['snacks'] )
			array_push($food_options, array( 'value' => $food_type_cats['snacks'], 'title' => 'Snack' ));

		$food_type_filter = array(
			'title'     => __('TIPO', 'pedigree-genosha'),
			'type'      => 'radio',
			'options'   => $food_options,
			'settings'  => array(
				'class'     => 'col-12 col-lg-4',
			),
		);
		$filters['food_type'] = $food_type_filter;
	}

	// =====================================================================
	// AGE FILTERS
	// =====================================================================
	$age_cats = json_decode(get_theme_mod('pedigree-age-filter', ''), true);
	if( is_array($age_cats) && !empty($age_cats) ){
		$age_options = array();
		if( $age_cats['puppy'] )
			array_push($age_options, array( 'value' => $age_cats['puppy'], 'title' => 'Cachorro' ));
		if( $age_cats['adult'] )
			array_push($age_options, array( 'value' => $age_cats['adult'], 'title' => 'Adulto' ));
		if( $age_cats['senior'] )
			array_push($age_options, array( 'value' => $age_cats['senior'], 'title' => 'Adulto 7+' ));

		$age_filter = array(
			'title'     => __('EDAD', 'pedigree-genosha'),
			'type'      => 'radio',
			'options'   => $age_options,
			'settings'  => array(
				'class'     => 'col-12 col-lg-4',
			),
		);
		$filters['age'] = $age_filter;
	}

	// =====================================================================
	// SIZE FILTERS
	// =====================================================================
	$size_cats = json_decode(get_theme_mod('pedigree-size-filter', ''), true);

	if( is_array($size_cats) && !empty($size_cats) ){
		$size_options = array();
		if( $size_cats['small'] )
			array_push($size_options, array( 'value' => $size_cats['small'], 'title' => 'Pequeña' ));
		if( $size_cats['medium'] )
			array_push($size_options, array( 'value' => $size_cats['medium'], 'title' => 'Mediana' ));
		if( $size_cats['big'] )
			array_push($size_options, array( 'value' => $size_cats['big'], 'title' => 'Grande' ));

		$size_filter = array(
			'title'     => __('RAZA', 'pedigree-genosha'),
			'type'      => 'radio',
			'options'   => $size_options,
			'settings'  => array(
				'class'     => 'col-12 col-lg-4',
			),
		);
		$filters['size'] = $size_filter;
	}

	$pedigree_filter = new RB_Filter_Panel('products-filter', $filters, array('filter-class' => 'row'));

	return $pedigree_filter;
}

// =============================================================================
// STORES
// =============================================================================
function print_stores_logos( $stores ){
	if( is_array($stores) && !empty($stores) ):
	?>
	<ul class="stores pedigree-light-scrollbar">
		<?php
		foreach( $stores as $store ):
			if( is_array($store) && $store['id'] && $store['link'] ):
				$storeID = $store['id'];
				$link = $store['link'];
				$store_post = get_post(intval($storeID));
				if($store_post && get_post_status($store_post) == 'publish'):
					$thumbnail = get_the_post_thumbnail_url($storeID);
				?>
					<li>
						<a href="<?php echo esc_attr($link); ?>" title="<?php echo esc_attr($store_post->post_title); ?>" target="_blank">
							<img alt="<?php echo esc_attr($store_post->post_title); ?>" src="<?php echo esc_attr($thumbnail); ?>">
						</a>
					</li>
				<?php
				endif;
			endif;
		endforeach;
		?>
	</ul>
	<?php
	endif;
}

// =============================================================================
// IMAGES
// =============================================================================
function pd_get_random_sad_image(){
	$rand_num = rand(1,4);
	return get_template_directory_uri() . "/assets/img/esp/sad-$rand_num.png";
}

function pd_get_random_happy_image(){
	$rand_num = rand(1,3);
	return get_template_directory_uri() . "/assets/img/esp/happy-$rand_num.png";
}

// =============================================================================
// FUNCTIONS
// =============================================================================

function get_related_posts($post, $amount = 3){
	$tags = wp_get_post_tags($post->ID);
	$tags_ids = array();
	$related_posts = null;
	if ($tags) {
		if($tags){
			foreach($tags as $tag){
				array_push($tags_ids, $tag->term_id);
			}
		}
		$args = array(
			'tag__in' 			=> $tags_ids,
			'post__not_in' 		=> array($post->ID),
			'posts_per_page'	=> $amount,
			//'orderby'           => 'rand',
		);
		$related_posts = get_posts($args);
	}
	return $related_posts;
}

function get_menu_items_by_registered_slug($menu_slug) {

    $menu_items = array();

	$get_childs = function (&$items, &$current) use (&$get_childs){
		$current->childrens = array();
		if( is_array($items) ){
			foreach($items as $key => $item){
				if($item->ID != $current->ID && $item->menu_item_parent == $current->ID){
					$get_childs($items, $item);
					unset($items[$key]);
					array_push($current->childrens, $item);
				}
			}
		}
	};

	$list_to_tree = function ($list) use ($get_childs){
		if( is_array($list) ){
			foreach($list as $item){
				$get_childs($list, $item);
			}
		}
		return $list;
	};

    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_slug ] ) ) {
        $menu = get_term( $locations[ $menu_slug ] );

        $menu_items = wp_get_nav_menu_items($menu->term_id);

		$menu_items = $list_to_tree($menu_items);
    }

    return $menu_items;

}

function get_most_recent_post( $args = array( 'post_type' => 'post' ) ){
	$most_recent_post = null;
	//The query to get the latest post
	$the_query = new WP_Query($args);
	//If there is a post

	if ( $the_query->have_posts() ){
		$the_query->the_post();
		$most_recent_post = $the_query->post;
	}
	//reset wordpress post globals
	wp_reset_postdata();

	return $most_recent_post;
}

// retrieves the attachment ID from the file URL
function rb_get_attachment_id($image_url) {
    global $wpdb;
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
    return $attachment[0];
}
// =============================================================================
// CUSTOMIZER
// =============================================================================
require get_template_directory() . '/inc/rb-wordpress-framework/customizer/rb-customizer.php';

function rb_customizer( $wp_customize ) {
	require get_template_directory() . '/customizer.php';
}
add_action( 'customize_register', 'rb_customizer' );

function pedigree_get_featured_post(){
	$cover_post = null;

	$cover_info = json_decode(get_theme_mod('pedigree-featured-post-info', ''), true);
	if( $cover_info ){
		if($cover_info["use_most_recent"]){
			$cover_post = get_most_recent_post();
		}
		else if(isset($cover_info["post_id"]))
			$cover_post = get_post($cover_info["post_id"]);
	}

	return $cover_post;
}

?>
