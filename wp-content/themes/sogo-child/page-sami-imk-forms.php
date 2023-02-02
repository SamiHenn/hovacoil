<!--?php /* Template Name: page-sami-imk-forms*/ ?-->
<div class="">
<?php

get_header();

?>
</div>


    <!-- BANNER -->
    <?php include('templates/content-header-banner-with-button-products.php'); ?>


<div class="container-fluid bg-8">

        <!-- CONTENT -->
        <div class="row justify-content-center">
            <!-- TEXT -->
            <div class="col-lg-8">
            <div style="position: fixed; top: 90px; left: 0px; right: 0px; bottom: 0px; z-index: 3">
<div style="position: fixed; top: 90px; left: 0px; right: 0px; bottom: 0px; z-index: 3">
<iframe style = "height: 100%; width: 100%;"; src="https://hova.bestweb.co.il/Show_form/<?php echo ($_GET['formId']); ?>" border="0" scrolling="yes" marginheight="0" marginwidth="0" frameborder="0" style="float:left; margin-left:0px" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true"></iframe></div>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

            </div>
        </div>
    </div>


<?php get_footer() ?>