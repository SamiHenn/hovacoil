<?php
get_header();
//the_post();
?>

    <!-- BANNER -->
    <?php include('templates/content-header-banner.php'); ?>


    <!-- BREADCRUMBS -->
<?php get_template_part('templates/content', 'breadcrumbs'); ?>

    <div class="container-fluid text-center bg-8">

        <!-- TEXT -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h1 class="text-1 color-4 mb-2"><?php the_field('_sogo_404_title', 'option'); ?></h1>
                <div class="entry-content">
                    <?php the_field('_sogo_404_content', 'option'); ?>
                </div>
            </div>
        </div>

        <!-- BUTTON -->
        <div class="row justify-content-center mb-2">
            <div class="col-12">
                <a href="<?php echo home_url(); ?> "
                   class="s-button s-button-2 bg-5 border-color-5">
                    <span class="align-middle"><?php _e('Back to homepage', 'sogoc'); ?></span>
                    <i class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>
                </a>
            </div>
        </div>

        <div class="row justify-content-between align-items-end border-bottom border-width-x2 border-color-6">
            <div class="bottom-right-image p-relative">
                <?php echo wp_get_attachment_image(get_field('_sogo_bottom_right_image','option'), 'full'); ?>
            </div>

            <div class="bottom-left-image p-relative hidden-md-down">
                <?php echo wp_get_attachment_image(get_field('_sogo_bottom_left_image','option'), 'full'); ?>
            </div>
        </div>



    </div>

<?php get_footer() ?>