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
			'title'          => __('Front page', 'pedigree-genosha'),
			'description'    => __('Configuración del front page', 'pedigree-genosha'),
		)
	);

	if( PED_FEATURED_POST ){
		$customizer_api->add_section(
			'pedigree-featured-post',
			array(
		        'title'     => __('Artículo destacado', 'pedigree-genosha'),
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
			'RB_Inputs_Control',//control class
			array(//Settings creation
				'pedigree-featured-post-info' => array(
					'options' => array(
						'transport' => 'postMessage',
						'default'	=> '',
					),
				)
			),
			array(//Control options
				'label'      			=> __( 'Cover', 'pedigree-genosha' ),
				'inputs_types'       	=> array(
					'use_most_recent'	=>	array(
						'nice_name'		=>	__( 'Usar post más reciente', 'pedigree-genosha' ),
						'type'			=>  "checkbox",
						'dependencies'	=> 'post_id',
						'reverse_dependencies'	=> true,
						'default'		=> true,
					),
					'post_id'				=>	array(
						'nice_name'		=>	__( 'Post', 'pedigree-genosha' ),
						'type'			=>  "post",
						//'dependencies'	=> 'use_post_data',
					),
					'use_post_data'		=>	array(
						'nice_name'		=>	__( 'Usar datos del post', 'pedigree-genosha' ),
						'type'			=>  "checkbox",
						'dependencies'	=> 'title,text,image',
						'reverse_dependencies'	=> true,
					),
					'title'				=>	array(
						'nice_name'		=>	__( 'Título', 'pedigree-genosha' ),
						'type'			=>  "text",
					),
					'text'				=>	array(
						'nice_name'		=>	__( 'Texto', 'pedigree-genosha' ),
						'type'			=>  "text",
					),
					'image'		=>	array(
						'nice_name'		=>	__( 'Imagen', 'pedigree-genosha' ),
						'type'			=>  "image",
					),
				),
			)
		);
	}

	$customizer_api->add_section(
		'pedigree-slider',
		array(
	        'title'     => __('Slider', 'pedigree-genosha'),
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
		'RB_Inputs_Generator_Control',//control class
		array(//Settings creation
			'pedigree-slider-content' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> true,
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Slide', 'pedigree-genosha' ),
			'inputs_types'       	=> array(
				'name'				=>	array(
					'nice_name'		=>	__( 'Título', 'pedigree-genosha' ),
					'type'			=>  "text",
				),
				'background_image'		=>	array(
					'nice_name'		=>	__( 'Imagen de fondo', 'pedigree-genosha' ),
					'type'			=>  "image",
				),
				'text'				=>	array(
					'nice_name'		=>	__( 'Descripción', 'pedigree-genosha' ),
					//'type'			=>  "texteditor",
					'type'			=>  "textarea",
				),
				'side_image'		=>	array(
					'nice_name'		=>	__( 'Imagen de contenido', 'pedigree-genosha' ),
					'type'			=>  "image",
				),
				'side_image_link'	=>	array(
					'nice_name'		=>	__( 'Link de la imagen', 'pedigree-genosha' ),
					'type'			=>  "text",
				),
				'video_id'				=>	array(
					'nice_name'		=>	__( 'ID video de Youtube', 'pedigree-genosha' ),
					'type'			=>  "text",
				),
				'url'				=>	array(
					'nice_name'		=>	__( 'Link/URL', 'pedigree-genosha' ),
					'type'			=>  "text",
				),
				'button_text'		=> array(
					'nice_name'		=>	__( 'Texto del botón', 'pedigree-genosha' ),
					'type'			=>  "text",
					'default'		=>  "MÁS INFO",
				),
				'reverse'			=>	array(
					'nice_name'		=>	__( 'Descripción a la izquierda', 'pedigree-genosha' ),
					'type'			=>  "checkbox",
				),
			),
			'inputs_title'			=> "Slide",
			'dinamic_label'			=> 'name',
		)
	);


	$rows_section = $customizer_api->add_section(
		'pedigree-triple-content-1',
		array(
	        'title'     => __('Links', 'pedigree-genosha'),
	        'priority'  => 1,
			'panel'  	=> 'front_page_panel',
	    ),
		array(
			'activated' 		=> true,
			'selector'			=>	"#links-section-container",
			'render_callback' 	=> function(){
	            get_template_part("parts/front", "list-1");
	        },
			'fallback_refresh'		=> true,
			'container_inclusive'	=>	true,
		)
	);

	for( $i = 1; $i <= PED_FIRST_LINK_SEC_ROWS_AMOUNTS; $i++){
		$rows_section->add_control(//Control creation
			"pedigree-columns-section-$i-title",//id
			'RB_Extended_Control',//control class
			array(//Settings creation
				"pedigree-columns-section-$i-title" => array(
					'options' => array(
						'transport' => 'postMessage',
						'default'	=> '',
					),
				)
			),
			array(//Control options
				'label'      		=> __( 'Título', 'pedigree-genosha' ),
				'type'           	=> 'text',
				'separator_content'	=> "Fila $i",
			)
		)
		->add_control(//Control creation
			"pedigree-columns-section-$i-content",//id
			'RB_Inputs_Generator_Control',//control class
			array(//Settings creation
				"pedigree-columns-section-$i-content" => array(
					'options' => array(
						'transport' => 'postMessage',
						'default'	=> true,
					),
				)
			),
			array(//Control options
				'label'      			=> __( "Fila $i", 'pedigree-genosha' ),
				'inputs_types'       	=> array(
					'name'				=>	array(
						'nice_name'		=>	__( 'Título', 'pedigree-genosha' ),
						'type'			=>  "text",
					),
					'image'				=>	array(
						'nice_name'		=>	__( 'Imagen', 'pedigree-genosha' ),
						'type'			=>  "image",
					),
					'url'				=>	array(
						'nice_name'		=>	__( 'Link/URL', 'pedigree-genosha' ),
						'type'			=>  "text",
					),
					'alt_color'			=>	array(
						'nice_name'		=>	__( 'Color alternativo', 'pedigree-genosha' ),
						'type'			=>  "checkbox",
					),
				),
				'inputs_title'			=> "Columna",
				'dinamic_label'			=> 'name',
			)
		);
	}




	/*$customizer_api->add_section(
		'pedigree-triple-content-2',
		array(
	        'title'     => __('Links 2', 'pedigree-genosha'),
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
			'label'      		=> __( 'Título', 'pedigree-genosha' ),
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
			'label'      			=> __( 'Columnas', 'pedigree-genosha' ),
			'inputs_types'       	=> array(
				'name'				=>	array(
					'nice_name'		=>	__( 'Título', 'pedigree-genosha' ),
					'type'			=>  "text",
				),
				'image'				=>	array(
					'nice_name'		=>	__( 'Imagen', 'pedigree-genosha' ),
					'type'			=>  "image",
				),
				'url'				=>	array(
					'nice_name'		=>	__( 'Link/URL', 'pedigree-genosha' ),
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
	        'title'     => __('Redes sociales', 'pedigree-genosha'),
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
		'RB_Inputs_Generator_Control',//control class
		array(//Settings creation
			'pedigree-social-networks' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> true,
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Redes Sociales', 'pedigree-genosha' ),
			'inputs_types'       	=> array(
				'name'				=>	array(
					'nice_name'		=>	__( 'Nombre', 'pedigree-genosha' ),
					'type'			=>  "text",
				),
				'fa'				=>	array(
					'nice_name'		=>	__( 'Icono', 'pedigree-genosha' ),
					'description'	=>  __( 'De fontawesome', 'pedigree-genosha' ),
					'type'			=>  "fontawesome",
				),
				'url'				=>	array(
					'nice_name'		=>	__( 'Link/URL', 'pedigree-genosha' ),
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
	        'title'     => __('Footer', 'pedigree-genosha'),
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
		'WP_Customize_Image_Control',//control class
		array(//Settings creation
			'pedigree-footer-image' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      		=> __( 'Imagen', 'pedigree-genosha' ),
		)
	)
	->add_control(//Control creation
		'pedigree-footer-text',//id
		'RB_Extended_Control',//control class
		array(//Settings creation
			'pedigree-footer-text' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      		=> __( 'Texto', 'pedigree-genosha' ),
			'type'           	=> 'textarea',
		)
	)
	->add_control(//Control creation
		'pedigree-footer-links',//id
		'RB_Inputs_Generator_Control',//control class
		array(//Settings creation
		   'pedigree-footer-links' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Links', 'pedigree-genosha' ),
			'inputs_types'       	=> array(
				'text'				=>	array(
					'nice_name'		=>	__( 'Texto', 'pedigree-genosha' ),
					'type'			=>  "text",
				),
				'url'				=>	array(
					'nice_name'		=>	__( 'Link/URL', 'pedigree-genosha' ),
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
		        'title'     => __('Sucursales', 'pedigree-genosha'),
		        'priority'  => 3,
		    ),
			array(
				'activated' 		=> false,
			)
		)
		->add_control(//Control creation
			'pedigree-branches-csv',//id
			'WP_Customize_Image_Control',//control class
			array(//Settings creation
				'pedigree-branches-csv' => array(
					'options' => array(
						'transport' => 'postMessage',
						'default'	=> '',
					),
				)
			),
			array(//Control options
				'label'      		=> __( 'CSV', 'pedigree-genosha' ),
				'button_labels'		=> array(
					'select'       => __( 'Seleccionar .csv', 'pedigree-genosha' ),
					'change'       => __( 'Cambiar .csv', 'pedigree-genosha' ),
					'remove'       => __( 'Quitar', 'pedigree-genosha' ),
					'placeholder'  => __( 'Seleccione archivo .csv', 'pedigree-genosha' ),
					'frame_title'  => __( 'Seleccionar .csv', 'pedigree-genosha' ),
					'frame_button' => __( 'Elegir .csv', 'pedigree-genosha' ),
				),
				'mime_type'			=> 'text/csv',
			)
		)
		->add_control(//Control creation
			'pedigree-add-store-page',//id
			'RB_Single_Input_Control',//control class
			array(//Settings creation
				'pedigree-add-store-page' => array(
					'options' => array(
						'transport' => 'postMessage',
						'default'	=> -1,
					),
				)
			),
			array(//Control options
				'label'      			=> __( 'Página de formulario  nueva tienda', 'pedigree-genosha' ),
				'input_type'       		=> "page",
				'inputs_title'			=> "Página",
				'dinamic_label'			=> 'page',
			)
		);
	}

	$customizer_api->add_section(
		'pedigree-blog',
		array(
	        'title'     => __('Blog', 'pedigree-genosha'),
	        'priority'  => 3,
			'description'	=> 'Datos a usar en la página seleccionada como blog',
	    ),
		array(
			'activated' 		=> true,
		)
	)
	->add_control(//Control creation
		'pedigree-blog-title',//id
		'RB_Extended_Control',//control class
		array(//Settings creation
			'pedigree-blog-title' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> 'Articulos Pedigree®',
				),
			)
		),
		array(//Control options
			'label'      		=> __( 'Título', 'pedigree-genosha' ),
			'type'           	=> 'text',
		)
	)
	->add_control(//Control creation
		'pedigree-blog-text',//id
		'RB_Extended_Control',//control class
		array(//Settings creation
			'pedigree-blog-text' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
				'label'      		=> __( 'Texto', 'pedigree-genosha' ),
			'type'           	=> 'textarea',
		)
	);

	$customizer_api->add_section(
		'pedigree-product-filters',
		array(
	        'title'     => __('Filtro de productos', 'pedigree-genosha'),
	        'priority'  => 3,
	    ),
		array(
			'activated' 		=> false,
		)
	)
	->add_control(//Control creation
		'pedigree-food-type-filter',//id
		'RB_Inputs_Control',//control class
		array(//Settings creation
			'pedigree-food-type-filter' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Tipo de alimento', 'pedigree-genosha' ),
			'inputs_types'       	=> array(
				'dry'				=>	array(
					'nice_name'		=>	__( 'Secos', 'pedigree-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'moist'				=>	array(
					'nice_name'		=>	__( 'Húmedos', 'pedigree-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'snacks'				=>	array(
					'nice_name'		=>	__( 'Snacks', 'pedigree-genosha' ),
					'type'			=>  "pedigree-category",
				),
			),
			'inputs_title'			=> "Categoría",
		)
	)
	->add_control(//Control creation
		'pedigree-size-filter',//id
		'RB_Inputs_Control',//control class
		array(//Settings creation
			'pedigree-size-filter' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Tamaño del perro', 'pedigree-genosha' ),
			'inputs_types'       	=> array(
				'small'				=>	array(
					'nice_name'		=>	__( 'Pequeño', 'pedigree-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'medium'				=>	array(
					'nice_name'		=>	__( 'Mediano', 'pedigree-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'big'				=>	array(
					'nice_name'		=>	__( 'Grande', 'pedigree-genosha' ),
					'type'			=>  "pedigree-category",
				),
			),
			'inputs_title'			=> "Categoría",
		)
	)
	->add_control(//Control creation
		'pedigree-age-filter',//id
		'RB_Inputs_Control',//control class
		array(//Settings creation
			'pedigree-age-filter' => array(
				'options' => array(
					'transport' => 'postMessage',
					'default'	=> '',
				),
			)
		),
		array(//Control options
			'label'      			=> __( 'Edad del perro', 'pedigree-genosha' ),
			'inputs_types'       	=> array(
				'puppy'				=>	array(
					'nice_name'		=>	__( 'Cachorro', 'pedigree-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'adult'				=>	array(
					'nice_name'		=>	__( 'Adulto', 'pedigree-genosha' ),
					'type'			=>  "pedigree-category",
				),
				'senior'				=>	array(
					'nice_name'		=>	__( 'Adulto 7+', 'pedigree-genosha' ),
					'type'			=>  "pedigree-category",
				),
			),
			'inputs_title'			=> "Categoría",
		)
	);

}


	$customizer_api = new RB_Customizer_API($wp_customize, 'customizer_api_configuration');
	$customizer_api->initialize();
