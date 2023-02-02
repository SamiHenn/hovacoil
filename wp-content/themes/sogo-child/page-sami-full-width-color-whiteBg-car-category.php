<!--?php /* Template Name: page-sami-full-width-color-whiteBg-car-category*/ ?-->
<?php
// 21.7.2021 - sami -  send user with old link to calculator of the same type of insurance with the ins_order
if(isset($_GET['ins_order'])) {
echo "<script type='text/javascript'>  window.location='calc/?ins_order=".$_GET['ins_order']."'; </script>";
}
get_header();
?>
    <div align="center" style="padding-left: 0px;  padding-right: 0px" class="container-fluid bg-8">
        <!-- CONTENT -->
        <div class="row justify-content-center">
            <!-- TEXT -->
            <div align="center" class="col-lg-12">
                <div align="center" class="entry-content">
                    <?php the_content(); ?>
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

<?php get_footer() ?>