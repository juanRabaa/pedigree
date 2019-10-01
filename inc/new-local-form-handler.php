<?php
//when a form is submitted to admin-post.php
add_action( 'admin_post_nopriv_pd_new_local_form_response', 'pd_new_local_form_handle');
add_action( 'admin_post_pd_new_local_form_response', 'pd_new_local_form_handle');
//when a form is submitted to admin-ajax.php
add_action( 'wp_ajax_nopriv_pd_new_local_form_response', 'pd_new_local_form_handle');
add_action( 'wp_ajax_pd_new_local_form_response', 'pd_new_local_form_handle');

//The form proccesing
function pd_new_local_form_handle(){
    // =============================================================================
    // NONCE PROTECTION
    // =============================================================================
    if( !isset( $_POST['pd_add_local_nonce'] ) || !wp_verify_nonce( $_POST['pd_add_local_nonce'], 'pd_add_local_form_nonce') ){
        wp_die( __( 'Invalid nonce specified', get_stylesheet() ), __( 'Error', get_stylesheet() ), array(
            'response' 	=> 403,
            'back_link' => '/',
        ));
    }

    // =========================================================================
    // DATA
    // =========================================================================
    $name = sanitize_text_field($_POST['vet-name']);
    $razon_social = sanitize_text_field($_POST['new-razon-social']);
    $address = sanitize_text_field($_POST['vet-address']);
    $localidad = sanitize_text_field($_POST['vet-city']);
    $provincia = sanitize_text_field($_POST['vet-province']);
    $phone = sanitize_text_field($_POST['vet-province']);
    $timetable = sanitize_text_field($_POST['vet-hours']);
    $email = sanitize_email($_POST['vet-email']);
    $fantasia_id = $_POST['ndf'] != 'otro' ? intval($_POST['ndf']) : -1;
    $new_fantasia_web = sanitize_text_field($_POST['new-ndf-web']);
    $new_fantasia_name = sanitize_text_field($_POST['new-ndf-name']);
    $marca_eukanuba = boolval($_POST['marca-eukanuba']);
    $marca_iams = boolval($_POST['marca-iams']);
    $marca_pedigree = boolval($_POST['marca-pedigree']);
    $marca_whiskas = boolval($_POST['marca-whiskas']);


    // =========================================================================
    // Term - Nombre de fantasia
    // =========================================================================
    //Si se ingreso un nombre de fantasia nuevo
    if( $fantasia_id == -1 && $new_fantasia_name ){
        $fantasia_term_id = pd_insert_new_fantasy($new_fantasia_name, array('url'  => $new_fantasia_web));
    }
    else{//Sino se usa el nombre de fantasia seleccionado
        $fantasia_term_id = $fantasia_id;
    }

    //Si el term id del nombre de fantasia no es valido, exit.
    if(is_wp_error($fantasia_term_id) || !isset($fantasia_term_id) || $fantasia_term_id == -1){
        $error_type = "unkown_error";
        if( !isset($fantasia_term_id) )
            $error_type = "fantasy_term_id isn't set";
        else if( is_wp_error($fantasia_term_id) )
            $error_type = "wp_error";
        else if( $fantasia_term_id == -1 )
            $error_type = "term_id -1";

        $message = json_encode( array(
            'text'          => 'Error al crear/seleccionar el nombre de fantasía',
            'error_type'    => $error_type,
            'error'         => $fantasia_term_id,
        ));

        wp_die( $message, __( 'Error', get_stylesheet() ), array(
            'response' 	=> 500,
            'back_link' => '/',
        ));
    }

    // =========================================================================
    // Post - Local
    // =========================================================================
    $new_local_data = array(
        'sucursal'      => $name,
        'razon_social'  => $razon_social,
        'address'       => $address,
        'localidad'     => $localidad,
        'provincia'     => $provincia,
        'phone'         => $phone,
        'timetable'     => $timetable,
        'email'         => $email,
        'lat'           => '',
        'long'          => '',
        'productos'     => array(
            'eukanuba'  => $marca_eukanuba,
            'iams'      => $marca_iams,
            'pedigree'  => $marca_pedigree,
            'whiskas'   => $marca_whiskas,
        ),
    );
    $new_local_id = pd_insert_new_local($new_local_data, $fantasia_term_id, 'pending');

    if( is_wp_error($new_local_id) || !is_int($new_local_id) ){
        wp_die( __( 'Error al crear el post del local', get_stylesheet() ), __( 'Error', get_stylesheet() ), array(
            'response' 	=> 500,
            'back_link' => '/',
        ));
    }

    // =========================================================================
    // RESPONSE
    // =========================================================================
    echo '<pre>';
    echo "ID del nuevo local: $new_local_id"; echo "<br>";
    echo "ID del nombre de fantasia: $fantasia_term_id"; echo "<br>";
    print_r($new_local_data); echo "<br>";
    echo '</pre>';

    die();
}
