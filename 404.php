<?php
/*
 *
*/
get_header();
set_query_var( 'hide_separator', true );
$imgs = array(
    "https://www.poochventures.com/wp-content/uploads/2016/02/ConfusedDog.png",
    "https://germanshepherdcountry.com/wp-content/uploads/2016/08/GSD-Question-Mark-GSC-800x474.jpg",
    "http://www.poshdogkneebrace.com/uploads/1/6/3/3/16337380/published/confused-dog.png?1527613400",
    "https://www.eejournal.com/wp-content/uploads/converted/149325662663/iStock_000045727868_Large.jpg",
);
?>
<!-- MAIN CONTENT -->
<div id="main-content" class="error-page-404">
    <div class="container error-page">
        <div class="page-header">
            <h1 class="display-2 title">404 Error</h1>
            <p class="description">La página solicitada no existe</p>
        </div>
        <img src="<?php echo $imgs[array_rand($imgs)]; ?>" class="confused-dog aligncenter">
    </div>
</div>
<?php get_footer(); ?>
