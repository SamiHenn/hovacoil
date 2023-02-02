<?php $mobile = wp_is_mobile() ? 'text-center col-12' : 'col-2'; ?>
<?php $mobile_padding = wp_is_mobile() ? 'py-3' : 'py-4'; ?>
<?php $copyright_right = wp_is_mobile() ? 'col-12 text-center' : 'col-lg-4 text-right'; ?>
<?php $copyright_left = wp_is_mobile() ? 'col-12 text-center' : 'col-lg-4 text-left'; ?>
<?php $facebook = wp_is_mobile() ? 'd-none' : 'd-block'; ?>
<?php $logo_margin = wp_is_mobile() ? '' : 'mb-3'; ?>

<footer class="footer-2 bg-white color-white">
    <div class="container-fluid">

        <div class="row justify-content-lg-center <?php echo $mobile_padding; ?> bg-4">

            <!-- SOCIAL -->
            <div class="footer-2__col <?php echo $mobile; ?> social">
                <a href="<?php echo home_url(); ?>" class="footer-2__logo d-inline-block <?php echo $logo_margin; ?> ">
                    <img src="<?php echo ROOT_PATH . '/images/logohovawhite.png'; ?> " alt="logo" class="img-fluid">
                </a>
                <a href="#" class="<?php echo $facebook; ?> ">
                    <i class="icon-facebook-01-colorwhite icon-x3 d-inline-block align-middle"></i>
                    <span class="d-inline-block align-middle"><?php _e( 'Visit Us On Facebook', 'sogoc' ); ?>  </span>
                </a>
                <!--                --><?php //dynamic_sidebar('footer1') ?>
            </div>

            <!-- MENU -->
            <div class="footer-2__col <?php echo $mobile; ?> ">
				<?php dynamic_sidebar( 'footer2' ) ?>
            </div>

            <!-- MENU -->
            <div class="footer-2__col <?php echo $mobile; ?> ">
				<?php dynamic_sidebar( 'footer3' ) ?>
            </div>

            <!-- MENU -->
            <div class="footer-2__col <?php echo $mobile; ?> ">
				<?php dynamic_sidebar( 'footer4' ) ?>
            </div>

        </div>

        <!-- COPYRIGHTS -->
        <div class="row justify-content-center bg-white py-1">

            <div class="<?php echo $copyright_right; ?>">
                <div class="copyrights margin-top-lg">
                    <span class="color-6 capture-text"><?php echo __( 'All right reserved to BITUACH HOVA', 'sogoc' ) . ' &copy;' ?></span>
                    <span class="color-6 capture-text"><?php echo date( "Y" ) ?></span>
                </div>
            </div>

            <div class="<?php echo $copyright_left; ?>">
                <a class="sogo-logo" href="https://sogo.co.il" target="_blank">
                    <span class="color-6 medium">SOGO Digital LTD</span>
					<?php echo sogo_file_get_contents( get_stylesheet_directory_uri() . '/images/sogo_logo_animated.svg' ); ?>
                </a>
            </div>

        </div>

    </div>
</footer>

<!-- page loader -->
<div class="loader-wrapper d-none">
    <div class="loader-inner">

        <!-- new loader -->

        <div class="new-loader px-2">

            <img src="<?php the_field( '_sogo_page_loader_logo', 'option' ); ?>"
                 alt="page loader" class="img-fluid mb-2">

            <p class="mb-1 medium color-4 text-p"><?php the_field( '_sogo_page_loader_title', 'option' ); ?></p>

            <p class="text-p color-6 normal mb-3"><?php the_field( '_sogo_page_loader_text', 'option' ); ?></p>

            <div class="loader-slider-wrapper mb-3 bg-white p-2 b-radius-50 border border-color-7 border-width-x1">
                <div class="js-page-loader-slider loader-logos">
					<?php
					$logos = get_field( '_sogo_page_loader_logo_gallery', 'option' );
					foreach ( $logos as $logo ):
						?>

                        <div class="mx-1">
                            <img src="<?php echo $logo['sizes']['company-logo']; ?>"
                                 alt="<?php $logo['alt']; ?>"
                                 class="mx-auto img-fluid">
                        </div>

					<?php endforeach; ?>
                </div>
            </div>

            <p class="text-p color-3 medium"><?php the_field( '_sogo_page_loader_bottom_text', 'option' ); ?></p>

        </div>


        <!-- old loader -->

        <!--        <div class="loader-inner-2">-->
        <!--            <div class="loader"></div>-->
        <!--        </div>-->
    </div>
</div>
