<?php
/*
 *  Template Name: Formulario de Contacto
 *
*/
get_header();
?>
<!-- MAIN CONTENT -->
<div id="main-content">
    <div class="container post-page">
    <?php while ( have_posts() ) : the_post(); ?>
        <div class="post-featured-image" style="background-image: url(<?php the_post_thumbnail_url('full'); ?>);"></div>
        <div class="post-content-box">
            <!-- <h1 class="display-4 post-title pedigree-main-color"><?php the_title(); ?></h1> -->
            <div class="post-content">
                 <?php echo the_content(); ?>
                 <div><script type="text/javascript" id="jsFastForms" src="https://sfapi.formstack.io/FormEngine/Scripts/Main.js?d=RUZTrbciR-liPoiMn4MQJF8IYi0f7bwL9KtFGyEBjrJ-UvtqvbdG1pQ8aolOY_1p">
                 </script>></div>
            </div>
        </div>
        <!--<div class="post-content-box">
            <h1 class="display-4 post-title pedigree-main-color"><?php the_title(); ?></h1>
            <div class="post-content">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="mars-form col-12">
                            <form>
                                <div class="form-group">
                                    <label class="required" for="subject">Motivo de la consulta</label>
                                    <select class="form-control form-control-lg" id="subject" name="subject">
                                      <option>1</option>
                                      <option>2</option>
                                      <option>3</option>
                                      <option>4</option>
                                      <option>5</option>
                                    </select>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6">
                                        <label for="name" class="required">Nombre</label>
                                        <input type="text" class="form-control form-control-lg" id="name" name="name" required="">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="surname" class="required">Apellido</label>
                                        <input type="text" class="form-control form-control-lg" id="surname" required="" name="surname">
​
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6">
                                        <label for="email" class="required">Email</label>
                                        <input type="text" class="form-control form-control-lg" id="email" name="email" required="">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="email-confirmation" class="required">Confirme su Email</label>
                                        <input type="text" class="form-control form-control-lg" id="email-confirmation" required="" name="email-confirmation">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12">
                                        <label for="birthday" class="required">Fecha de nacimiento</label>
                                        <input type="date" class="form-control form-control-lg" id="birthday" name="birthday" required="">
​
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6">
                                        <label for="phone" class="">Teléfono</label>
                                        <input type="text" class="form-control form-control-lg" id="phone" name="phone" required="">
​
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="address" class="">Dirección</label>
                                        <input type="text" class="form-control form-control-lg" id="address" name="address" required="">
​
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6">
                                        <label for="number" class="">Número</label>
                                        <input type="text" class="form-control form-control-lg" id="number" name="number" required="">
​
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6">
                                        <label for="postcode" class="">Código Postal</label>
                                        <input type="text" class="form-control form-control-lg" id="postcode" name="postcode" required="">
​
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12 col-md-6">
                                        <label for="city" class="">Ciudad</label>
                                        <input type="text" class="form-control form-control-lg" id="city" name="city" required="">
​
                                    </div>
                                    <div class="col-12 col-md-6">
​
                                        <label class="required" for="country">País</label>
                                        <select class="form-control form-control-lg" id="country" name="country">
                                          <option>1</option>
                                          <option>2</option>
                                          <option>3</option>
                                          <option>4</option>
                                          <option>5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12">
                                        <label class="required" for="comments">Comentarios</label>
                                        <textarea class="form-control form-control-lg" id="comments" rows="5"></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-12">
                                        <label class="required" for="have-product">¿Tiene todavía el producto?</label>
                                        <select class="form-control form-control-lg" id="have-product" name="have-product">
                                          <option>1</option>
                                          <option>2</option>
                                          <option>3</option>
                                          <option>4</option>
                                          <option>5</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-extra form-group full-width">
                                    <p>•The personal data submitted via this form will be retained only for the purpose of responding to your question or concern, and will not be used for marketing purposes.</p>
                                    <p>•You must be 16 years old or older to submit a form.</p>
                                </div>
                                <div class="more-button pedigree-main-color whole" type="submit">
                                    <span>ENVIAR</span>
                                    <i class="fas fa-caret-right"></i>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        -->
    <?php endwhile; // end of the loop. ?>
    </div>
</div>
<?php get_footer(); ?>
