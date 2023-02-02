<header class="header-2">
    <div class="container-fluid h-100">

        <?php if (wp_is_mobile()) : ?>


            <div class="row justify-content-between py-2 align-items-center h-100">

                <!-- STRIPES -->
                <div class="col-auto pr-15 text-right">
                    <div class="stripes-menu d-block">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>

                <!-- MOBILE MENU  -->
                <nav class="primary-menu primary-menu__hide py-1">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary_menu',
                        'depth' => 2,
                        'container' => false
                    ));
                    ?>
                </nav>

                <!-- MOBILE OFFER BUTTON -->
                <a href="#"
                   class="col-auto s-button s-button-3 bg-2 border-color-2 color-white d-inline-block align-middle mx-2 icon-arrow">
                    <span class="align-middle"><?php _e('OFFER In A Click', 'sogoc'); ?></span>
                    <i class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>
                </a>

                <!-- MOBILE LOGO -->
                <div class="col-auto mobile-logo pl-15 text-left">
                    <a href="<?php echo home_url(); ?>" class="d-inline-block">
                        <img src="<?php echo ROOT_PATH . '/images/logomobile.png'; ?> "
                             alt="logo"
                             class="img-fluid">
                    </a>
                </div>


            </div>

        <?php else: ?>
            <div class="row py-2 justify-content-between h-100 align-items-center">

                <div class="col-lg-auto pr-15 font-0 text-right align-self-center">
                    <!-- HOME -->
                    <a href="<?php echo home_url(); ?>"
                       class="icon-home-01-color6 icon-x5 d-inline-block align-middle bg-position-center mx-2"></a>
                    <!-- COSTUMER SERVICE BUTTON -->
                    <a href="#"
                       class="s-btn-1 align-middle mx-2"><?php _e('Costumer Service', 'sogoc'); ?></a>
                    <!-- MENU -->
                    <nav class="primary-menu text-left d-inline-block align-middle">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary_menu',
                            'depth' => 2,
                            'container' => false
                        ));
                        ?>
                    </nav>
                    <!-- OFFER BUTTON -->
                    <a href="#"
                       class="s-btn-2 d-inline-block align-middle mx-2">
                        <span><?php _e('OFFER In A Click', 'sogoc'); ?></span>
                        <?php echo sogo_file_get_contents(get_stylesheet_directory_uri() . '/images/arrowleft.svg'); ?>
<!--                        <i class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>-->
                    </a>
                </div>

                <!-- LOGO -->
                <div class="col-lg-auto pl-15 text-left">
                    <a href="<?php echo home_url(); ?>" class="d-inline-block ml-15">
                        <img src="<?php echo ROOT_PATH . '/images/logohovacolor.png'; ?> "
                             alt="logo"
                             class="img-fluid">
                    </a>
                </div>

            </div>
        <?php endif; ?>
    </div>
</header>