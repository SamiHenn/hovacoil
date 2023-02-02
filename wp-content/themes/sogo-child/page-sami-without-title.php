<!--?php /* Template Name: page-sami-without-title*/ ?-->
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
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>

            </div>
        </div>


        <div class="row justify-content-between align-items-end border-bottom border-width-x2 border-color-6">
            <div class="bottom-right-image p-relative">
                <?php echo wp_get_attachment_image(get_field('_sogo_bottom_right_image', 'option'), 'full'); ?>
            </div>

            <div class="bottom-left-image p-relative hidden-md-down">
                <?php echo wp_get_attachment_image(get_field('_sogo_bottom_left_image', 'option'), 'full'); ?>
            </div>
        </div>
    </div>


<?php get_footer() ?>