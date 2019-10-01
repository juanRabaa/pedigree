<?php
//Panel builder//
/******************************************************************************/
function customizer_api_configuration($customizer_api){

	$customizer_api->add_panel(
		'front_page_panel',
		array(
			'priority'       => 1,
			'capability'     => 'edit_theme_options',
			'theme_supports' => '',
			'title'          => __('Front page', 'whiskas-genosha'),
			'description'    => __('Configuración del front page', 'whiskas-genosha'),
		)
	);

	if( PED_FEATURED_POST ){
		$customizer_api->add_section(
			'pedigree-featured-post',
			array(
		        'title'     => __('Artículo destacado', 'whiskas-genosha'),
		        'priority'  => 1,
				'panel'  	=> 'front_page_panel',
		    ),
			array(
				'activated' 		=> true,
				'selector'  		=> '#featured-post-section',
				'render_callback' 	=> function(){
		            get_template_part("parts/front", "featured-post");
		        },
				'container_inclusive'	=>	true,
			)
		)
		->add_control(//Control creation
			'pedigree-featured-post-info',//id
			RB_Inputs_Control,//control class
			array(//Settings creation
				'pedigree-featured-post-info' => array(
					'options' => array(
						'transport' => 'postMessage',
						'default'	=> '',
					),
				)
			),
			array(//Control options
				'label'      			=> __( 'Cover', 'whiskas-genosha' ),
				'inputs_types'       	=> array(
					'use_most_recent'	=>	array(
						'nice_name'		=>	__( 'Usar post más reciente', 'whiskas-genosha' ),
						'type'			=>  "checkbox",
						'dependencies'	=> 'post_id',
						'reverse_dependencies'	=> true,
						'default'		=> true,
					),
					'post_id'				=>	array(
						'nice_name'		=>	__( 'Post', 'whiskas-genosha' ),
						'type'			=>  "post",
						//'dependencies'	=> 'use_post_data',
					),
					'use_post_data'		=>	array(
						'nice_name'		=>	__( 'Usar datos del post', 'whiskas-genosha' ),
						'type'			=>  "checkbox",
						'dependencies'	=> 'title,text,image',
						'reverse_dependencies'	=> true,
					),
					'title'				=>	array(
						'nice_name'		=>	__( 'Título', 'whiskas-genosha' ),
						'type'			=>  "text",
					),
					'text'				=>	array(
						'nice_name'		=>	__( 'Texto', 'whiskas-genosha' ),
						'type'			=>  "text",
					),
					'image'		=>	array(
						'nice_name'		=>	__( 'Imagen', 'whiskas-genosha' ),
						'type'			=>  "image",
					),
				),
			)
		);
	}

	$customizer_api->add_section(
		'pedigree-slider',
		array(
	        'title'     => __('Slider', 'whiskas-genosha'),
	        'priority'  => 1,
			'panel'  	=> 'front_page_panel',
	    ),
		array(
			'activated' 		=> true,
			'selector'			=>	"#slider-section",
			'render_callback' 	=> function(){
	            get_template_part("parts/front", "slider");
	        },
			'fallback_refresh'		=> true,
			'container_inclusive'	=>	true,
		)
	)
	->add_control(//Control creation
		'pedigree-slider-content',//id
		RB_Inputs_Generator_Control,//control class
		array(//Settings creation
			'pedigree-slider-content' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> true,
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Slide', 'whiskas-genosha' ),
			'inputs_types'       	=> array(
				'name'				=>	array(
					'nice_name'		=>	__( 'Título', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
				'background_image'		=>	array(
					'nice_name'		=>	__( 'Imagen de fondo', 'whiskas-genosha' ),
					'type'			=>  "image",
				),
				'text'				=>	array(
					'nice_name'		=>	__( 'Descripción', 'whiskas-genosha' ),
					//'type'			=>  "texteditor",
					'type'			=>  "textarea",
				),
				'side_image'		=>	array(
					'nice_name'		=>	__( 'Imagen de contenido', 'whiskas-genosha' ),
					'type'			=>  "image",
				),
				'side_image_link'	=>	array(
					'nice_name'		=>	__( 'Link de la imagen', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
				'video_id'				=>	array(
					'nice_name'		=>	__( 'ID video de Youtube', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
				'url'				=>	array(
					'nice_name'		=>	__( 'Link/URL', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
				'button_text'		=> array(
					'nice_name'		=>	__( 'Texto del botón', 'whiskas-genosha' ),
					'type'			=>  "text",
					'default'		=>  "MÁS INFO",
				),
				'reverse'			=>	array(
					'nice_name'		=>	__( 'Descripción a la izquierda', 'whiskas-genosha' ),
					'type'			=>  "checkbox",
				),
			),
			'inputs_title'			=> "Slide",
			'dinamic_label'			=> 'name',
		)
	);


	$customizer_api->add_section(
		'pedigree-triple-content-1',
		array(
	        'title'     => __('Links 1', 'whiskas-genosha'),
	        'priority'  => 1,
			'panel'  	=> 'front_page_panel',
	    ),
		array(
			'activated' 		=> true,
			'selector'			=>	"#list-1-section",
			'render_callback' 	=> function(){
	            get_template_part("parts/front", "list-1");
	        },
			'fallback_refresh'		=> true,
			'container_inclusive'	=>	true,
		)
	)
	->add_control(//Control creation
		'pedigree-columns-section-1-title',//id
		RB_Extended_Control,//control class
		array(//Settings creation
			'pedigree-columns-section-1-title' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      		=> __( 'Título', 'whiskas-genosha' ),
			'type'           	=> 'text',
		)
	)
	->add_control(//Control creation
		'pedigree-columns-section-1-content',//id
		RB_Inputs_Generator_Control,//control class
		array(//Settings creation
			'pedigree-columns-section-1-content' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> true,
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Columnas', 'whiskas-genosha' ),
			'inputs_types'       	=> array(
				'name'				=>	array(
					'nice_name'		=>	__( 'Título', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
				'image'				=>	array(
					'nice_name'		=>	__( 'Imagen', 'whiskas-genosha' ),
					'type'			=>  "image",
				),
				'url'				=>	array(
					'nice_name'		=>	__( 'Link/URL', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
				'alt_color'			=>	array(
					'nice_name'		=>	__( 'Color alternativo', 'whiskas-genosha' ),
					'type'			=>  "checkbox",
				),
			),
			'inputs_title'			=> "Columna",
			'dinamic_label'			=> 'name',
		)
	);

	/*$customizer_api->add_section(
		'pedigree-triple-content-2',
		array(
	        'title'     => __('Links 2', 'whiskas-genosha'),
	        'priority'  => 1,
			'panel'  	=> 'front_page_panel',
	    ),
		array(
			'activated' 		=> true,
			'selector'			=>	"#list-2-section",
			'render_callback' 	=> function(){
	            get_template_part("parts/front", "list-2");
	        },
			'fallback_refresh'		=> true,
			'container_inclusive'	=>	true,
		)
	)
	->add_control(//Control creation
		'pedigree-columns-section-2-title',//id
		RB_Extended_Control,//control class
		array(//Settings creation
			'pedigree-columns-section-2-title' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      		=> __( 'Título', 'whiskas-genosha' ),
			'type'           	=> 'text',
		)
	)
	->add_control(//Control creation
		'pedigree-columns-section-2-content',//id
		RB_Inputs_Generator_Control,//control class
		array(//Settings creation
			'pedigree-columns-section-2-content' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> true,
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Columnas', 'whiskas-genosha' ),
			'inputs_types'       	=> array(
				'name'				=>	array(
					'nice_name'		=>	__( 'Título', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
				'image'				=>	array(
					'nice_name'		=>	__( 'Imagen', 'whiskas-genosha' ),
					'type'			=>  "image",
				),
				'url'				=>	array(
					'nice_name'		=>	__( 'Link/URL', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
			),
			'inputs_title'			=> "Columna",
			'dinamic_label'			=> 'name',
		)
	);*/

	$customizer_api->add_section(
		'pedigree-social',
		array(
	        'title'     => __('Redes sociales', 'whiskas-genosha'),
	        'priority'  => 2,
	    ),
		array(
			'activated' 		=> true,
			'selector'  		=> '.pedigree-social',
			'render_callback' 	=> function(){
	            get_template_part("parts/content", "social");
	        },
			'container_inclusive'	=>	true,
		)
	)
	->add_control(//Control creation
		'pedigree-social-networks',//id
		RB_Inputs_Generator_Control,//control class
		array(//Settings creation
			'pedigree-social-networks' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> true,
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Redes Sociales', 'whiskas-genosha' ),
			'inputs_types'       	=> array(
				'name'				=>	array(
					'nice_name'		=>	__( 'Nombre', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
				'fa'				=>	array(
					'nice_name'		=>	__( 'Icono', 'whiskas-genosha' ),
					'description'	=>  __( 'De fontawesome', 'whiskas-genosha' ),
					'type'			=>  "fontawesome",
				),
				'url'				=>	array(
					'nice_name'		=>	__( 'Link/URL', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
			),
			'inputs_title'			=> "Red Social",
			'dinamic_label'			=> 'name',
		)
	);

	$customizer_api->add_section(
		'pedigree-footer',
		array(
	        'title'     => __('Footer', 'whiskas-genosha'),
	        'priority'  => 3,
	    ),
		array(
			'activated' 		=> true,
			'selector'  		=> '#footer',
			'render_callback' 	=> function(){
	            get_template_part("parts/part", "footer");
	        },
			'container_inclusive'	=>	true,
		)
	)
	->add_control(//Control creation
		'pedigree-footer-image',//id
		WP_Customize_Image_Control,//control class
		array(//Settings creation
			'pedigree-footer-image' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      		=> __( 'Imagen', 'whiskas-genosha' ),
		)
	)
	->add_control(//Control creation
		'pedigree-footer-text',//id
		RB_Extended_Control,//control class
		array(//Settings creation
			'pedigree-footer-text' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      		=> __( 'Texto', 'whiskas-genosha' ),
			'type'           	=> 'textarea',
		)
	)
	->add_control(//Control creation
		'pedigree-footer-links',//id
		RB_Inputs_Generator_Control,//control class
		array(//Settings creation
		   'pedigree-footer-links' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Links', 'whiskas-genosha' ),
			'inputs_types'       	=> array(
				'text'				=>	array(
					'nice_name'		=>	__( 'Texto', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
				'url'				=>	array(
					'nice_name'		=>	__( 'Link/URL', 'whiskas-genosha' ),
					'type'			=>  "text",
				),
			),
			'inputs_title'			=> "Link",
			'dinamic_label'			=> 'text',
		)
	);

	if( PEDIGREE_STORES_ACTIVATED ){
		$customizer_api->add_section(
			'pedigree-branches',
			array(
		        'title'     => __('Sucursales', 'whiskas-genosha'),
		        'priority'  => 3,
		    ),
			array(
				'activated' 		=> false,
			)
		)
		->add_control(//Control creation
			'pedigree-branches-csv',//id
			WP_Customize_Image_Control,//control class
			array(//Settings creation
				'pedigree-branches-csv' => array(
					'options' => array(
						'transport' => 'postMessage',
						'default'	=> '',
					),
				)
			),
			array(//Control options
				'label'      		=> __( 'CSV', 'whiskas-genosha' ),
				'button_labels'		=> array(
					'select'       => __( 'Seleccionar .csv', 'whiskas-genosha' ),
					'change'       => __( 'Cambiar .csv', 'whiskas-genosha' ),
					'remove'       => __( 'Quitar', 'whiskas-genosha' ),
					'placeholder'  => __( 'Seleccione archivo .csv', 'whiskas-genosha' ),
					'frame_title'  => __( 'Seleccionar .csv', 'whiskas-genosha' ),
					'frame_button' => __( 'Elegir .csv', 'whiskas-genosha' ),
				),
				'mime_type'			=> 'text/csv',
			)
		)
		->add_control(//Control creation
			'pedigree-add-store-page',//id
			RB_Single_Input_Control,//control class
			array(//Settings creation
				'pedigree-add-store-page' => array(
					'options' => array(
						'transport' => 'postMessage',
						'default'	=> -1,
					),
				)
			),
			array(//Control options
				'label'      			=> __( 'Página de formulario  nueva tienda', 'whiskas-genosha' ),
				'input_type'       		=> "page",
				'inputs_title'			=> "Página",
				'dinamic_label'			=> 'page',
			)
		);
	}

	$customizer_api->add_section(
		'pedigree-blog',
		array(
	        'title'     => __('Blog', 'whiskas-genosha'),
	        'priority'  => 3,
			'description'	=> 'Datos a usar en la página seleccionada como blog',
	    ),
		array(
			'activated' 		=> true,
		)
	)
	->add_control(//Control creation
		'pedigree-blog-title',//id
		RB_Extended_Control,//control class
		array(//Settings creation
			'pedigree-blog-title' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> 'Articulos Whiskas®',
				),
			)
		),
		array(//Control options
			'label'      		=> __( 'Título', 'whiskas-genosha' ),
			'type'           	=> 'text',
		)
	)
	->add_control(//Control creation
		'pedigree-blog-text',//id
		RB_Extended_Control,//control class
		array(//Settings creation
			'pedigree-blog-text' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
				'label'      		=> __( 'Texto', 'whiskas-genosha' ),
			'type'           	=> 'textarea',
		)
	);

	$customizer_api->add_section(
		'pedigree-product-filters',
		array(
	        'title'     => __('Filtro de productos', 'whiskas-genosha'),
	        'priority'  => 3,
	    ),
		array(
			'activated' 		=> false,
		)
	)
	->add_control(//Control creation
		'pedigree-food-type-filter',//id
		RB_Inputs_Control,//control class
		array(//Settings creation
			'pedigree-food-type-filter' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Tipo de alimento', 'whiskas-genosha' ),
			'inputs_types'       	=> array(
				'dry'				=>	array(
					'nice_name'		=>	__( 'Secos', 'whiskas-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'moist'				=>	array(
					'nice_name'		=>	__( 'Húmedos', 'whiskas-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'snacks'				=>	array(
					'nice_name'		=>	__( 'Snacks', 'whiskas-genosha' ),
					'type'			=>  "pedigree-category",
				),
			),
			'inputs_title'			=> "Categoría",
		)
	)
	->add_control(//Control creation
		'pedigree-size-filter',//id
		RB_Inputs_Control,//control class
		array(//Settings creation
			'pedigree-size-filter' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Tamaño del perro', 'whiskas-genosha' ),
			'inputs_types'       	=> array(
				'small'				=>	array(
					'nice_name'		=>	__( 'Pequeño', 'whiskas-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'medium'				=>	array(
					'nice_name'		=>	__( 'Mediano', 'whiskas-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'big'				=>	array(
					'nice_name'		=>	__( 'Grande', 'whiskas-genosha' ),
					'type'			=>  "pedigree-category",
				),
			),
			'inputs_title'			=> "Categoría",
		)
	)
	->add_control(//Control creation
		'pedigree-age-filter',//id
		RB_Inputs_Control,//control class
		array(//Settings creation
			'pedigree-age-filter' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Edad del perro', 'whiskas-genosha' ),
			'inputs_types'       	=> array(
				'puppy'				=>	array(
					'nice_name'		=>	__( 'Gatito', 'whiskas-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'adult'				=>	array(
					'nice_name'		=>	__( 'Adulto', 'whiskas-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'senior'				=>	array(
					'nice_name'		=>	__( 'Adulto 7+', 'whiskas-genosha' ),
					'type'			=>  "pedigree-category",
				),
			),
			'inputs_title'			=> "Categoría",
		)
	);

}


	$customizer_api = new RB_Customizer_API($wp_customize, 'customizer_api_configuration');
	$customizer_api->initialize();
