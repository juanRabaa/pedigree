<?php
/*
 *  Template Name: Formulario de nuevo local
 *
*/
get_header();
?>
<!-- MAIN CONTENT -->
<div id="main-content" class="form-new-place-page">
    <div class="container post-page">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="post-featured-image" style="background-image: url(<?php the_post_thumbnail_url('full'); ?>);"></div>
        <div class="post-content-box">
            <!-- <h1 class="display-4 post-title pedigree-main-color"><?php the_title(); ?></h1> -->
            <div class="post-content">
                 <?php echo the_content(); ?>
                 <form id="new-vet-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
                 		<div class="form-group">
                 			<label for="ndf">Nombre de Fantasía</label>
                 			<select class="form-control" id="ndf" name="ndf">
                 				<option value="otro">Otro - ingresar nuevo</option>
                 				<?php
                                    $nombres_tax = pedigree_get_nombre_fantasia();
                                    if (is_array($nombres_tax)):
                                        foreach ($nombres_tax as $nombre_tax):
                                            ?>
                 							   <option value="<?php echo esc_attr($nombre_tax->term_id); ?>"><?php echo esc_html($nombre_tax->name); ?></option>
                 						   <?php
                                        endforeach;
                                    endif;
                                 ?>
                 			</select>
                 			<div class="details"></div>
                 		</div>
                 		<div class="new-ndf">
                 			<div class="form-group">
                 				<label for="new-ndf-name">Nuevo nombre de Fantasía<span class="required"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
                 				<input type="text" required class="form-control" id="new-ndf-name" name="new-ndf-name" placeholder="Ingrese el nombre de su franquicia.">
                 			</div>
                 			<div class="form-group">
                 				<label for="new-ndf-web">Página Web</label>
                 				<input type="url" class="form-control" id="new-ndf-web" name="new-ndf-web" placeholder="Ej: http://www.ejemplo.com">
                 			</div>
                 		</div>
                 		<div class="form-group new-razon">
                 			<label for="new-razon-social">Razón Social<span class="required"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
                 			<input type="text" required class="form-control" id="new-razon-social" name="new-razon-social" placeholder="">
                 		</div>
                 		<div class="form-group">
                 			<label for="vet-name">Nombre de la sucursal<span class="required"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
                 			<input type="text" required class="form-control" id="vet-name" name="vet-name" aria-describedby="nameHelp" placeholder="Ej: NombreDeFantasía - Palermo">
                 			<small id="nameHelp" class="form-text text-muted">Es una forma significativa de identificar a la sucursal dentro de la franquicia.</small>
                 		</div>
                 		<div class="form-group">
                 			<label for="vet-address">Dirección<span class="required"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
                 			<input type="text" required class="form-control" id="vet-address" name="vet-address" placeholder="Ej: Av. Callao 2124" autocomplete="off">
                 		</div>
                 				<input readonly="" type="hidden" id="vet-lat" name="vet-lat">
                 		<input readonly="" type="hidden" id="vet-long" name="vet-long">
                 		<div class="form-group">
                 			<label for="vet-city">Localidad<span class="required"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
                 			<input data-places="locality" required type="text" class="form-control" id="vet-city" name="vet-city" placeholder="Ej: Quilmes">
                 		</div>
                 		<div class="form-group">
                 			<label for="vet-province">Provincia<span class="required"><i class="fa fa-asterisk" aria-hidden="true"></i></span></label>
                 			<input type="text" required data-places="administrative_area_level_1" class="form-control" id="vet-province" name="vet-province" placeholder="Ej: Buenos Aires">
                 		</div>

                 		<div class="form-group">
                 			<label for="vet-phone">Teléfono</label>
                 			<input type="tel" class="form-control" id="vet-phone" name="vet-phone" placeholder="Ej: 011 1234-5678">
                 		</div>
                 		<div class="form-group">
                 			<label for="vet-hours">Horario de atención</label>
                 			<input type="text" class="form-control" id="vet-hours" name="vet-hours" placeholder="Ej: Lunes a viernes de 8:00 a 18:00. Sábados de 8:00 a 12:00.">
                 		</div>
                 		<div class="form-group">
                 			<label for="vet-email">Email<span class="required"><i class="fa fa-asterisk" aria-hidden="true"></i></span>
                 			</label>
                 			<input type="email" required class="form-control" id="vet-email" name="vet-email" placeholder="nombre@ejemplo.com">
                 		</div>
                 		<div class="form-group group-marcas">
                 			<label for="">Marcas que vende
                 			</label>
                 			<div class="marcas">
                 				<div class="form-check">
                 					<label class="form-check-label">
                 						<input type="checkbox" class="form-check-input" name="marca-eukanuba">
                 						Eukanuba
                 					</label>
                 				</div>
                 				<div class="form-check">
                 					<label class="form-check-label">
                 						<input type="checkbox" class="form-check-input" name="marca-iams">
                 						IAMS
                 					</label>
                 				</div>
                 				<div class="form-check">
                 					<label class="form-check-label">
                 						<input type="checkbox" class="form-check-input" name="marca-pedigree">
                 						Pedigree
                 					</label>
                 				</div>
                 				<div class="form-check">
                 					<label class="form-check-label">
                 						<input type="checkbox" class="form-check-input" name="marca-whiskas">
                 						Whiskas
                 					</label>
                 				</div>
                 			</div>
                 		</div>
                 		<div class="form-group">
                 			<div class="form-check">
                 				<label class="form-check-label">
                 					<input type="checkbox" required class="form-check-input" id="terms-y-conds">
                 					Acepto los <b><a href="/app/uploads/2018/01/terminos-y-condiciones.pdf" target="_blank">Términos y condiciones</a></b>
                 				</label>
                 			</div>
                 		</div>
                 		<input type="hidden" name="action" value="pd_new_local_form_response">
                 		<input type="hidden" name="pd_add_local_nonce" value="<?php echo wp_create_nonce( 'pd_add_local_form_nonce' ); ?>" />
                        <?php pedigree_more_button(array(
            				'text'      => 'Enviar',
            				'url'       => $href_attr,
                            'attrs'     => array('type' => 'submit'),
                            'element'   => 'button',
                            'icon'      => false,
            			));?>
                 	</form>
                    <div class="form-response success-message">
                        <h1 class="title display-2">¡Genial!</h1>
                        <p>El formulario ha sido enviado correctamente. Tu tienda se encuentra en proceso de revisión.</p>
                        <a href="<?php echo esc_attr(get_home_url()); ?>">
                            <img src="<?php echo esc_attr(pd_get_random_happy_image()); ?>">
                        </a>
                    </div>
                    <div class="form-response error-message">
                        <h1 class="title display-3">Esto no debería pasar...</h1>
                        <p>Ha habido un error al procesar el formulario enviado. Por favor, vuelva a intentarlo.</p>
                        <a href="<?php echo esc_attr(get_home_url()); ?>">
                            <img src="<?php echo esc_attr(pd_get_random_sad_image()); ?>">
                        </a>
                    </div>
            </div>
        </div>
    <?php endwhile; // end of the loop. ?>
    </div>
</div>
<?php get_footer(); ?>
