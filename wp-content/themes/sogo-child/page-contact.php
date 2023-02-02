<?php // Template Name: contact page
get_header();
$sub_title = get_field('_sogo_contact_sub_title');
$mail = get_field('_sogo_contact_mail');
$phone = get_field('_sogo_contact_phone');

?>


<!-- BANNER -->
    <?php include('templates/content-header-banner.php'); ?>

<!-- BREADCRUMBS -->
<?php get_template_part('templates/content', 'breadcrumbs'); ?>


<div class="container-fluid bg-8">

    <!-- TEXT -->
    <div class="row justify-content-center mb-3">
        <div class="col-lg-8 text-center">
            <h1 class="text-1 color-4 mb-2"><?php the_title(); ?></h1>
            <h2 class="text-3 color-6"><?php echo $sub_title; ?></h2>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-lg-4">
            <?php echo do_shortcode('[contact-form-7 id="238" title="טופס יצירת קשר 1"]'); ?>
        </div>
        <div class="col-lg-2 mb-3 mb-lg-0">
            <div class="bg-3 custom-border-radius">
                <div class="d-flex flex-column justify-content-center align-items-center py-4 px-3">
                    <i class="icon-openenvelope-01-colorwhite icon-x6 mb-2"></i>
                    <span class="text-5 color-white mb-1"><?php _e('Email', 'sogoc'); ?></span>
                    <a href="mailto:<?php echo $mail; ?>"
                       class="text-5 color-white"><?php echo $mail; ?></a>
                </div>
            </div>
        </div>
        <div class="col-lg-2 mb-3 mb-lg-0">
            <div class="bg-4 custom-border-radius">
                <div class="d-flex flex-column justify-content-center align-items-center py-4 px-3">
                    <i class="icon-contact-01-colorwhite icon-x6 mb-2"></i>
                    <span class="text-5 color-white mb-1"><?php _e('Phone', 'sogoc'); ?></span>
                    <a href="phone:<?php echo $phone; ?>"
                       class="text-5 color-white"><?php echo $phone; ?></a>
                </div>
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


