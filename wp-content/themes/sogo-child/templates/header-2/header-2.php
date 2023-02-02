<header class="header-2">
    <div class="container-fluid">

		<?php if ( wp_is_mobile() ) : ?>

            <!-- row -->
            <div class="row justify-content-between align-items-center py-2">

                <div class="col-auto px-15">
                    <!-- row -->
                    <div class="row align-items-center">
                        <!-- STRIPES -->
                        <div class="col-auto px-15">
                            <div class="stripes-menu d-block">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                        <div class="col-auto">
							<?php if ( '' != get_field( '_sogo_header_2_button2_link', 'options' ) ): ?>
                                <!-- MOBILE OFFER BUTTON -->
                                <a href="<?php echo get_field( '_sogo_header_2_button2_link', 'options' ); ?>"
                                   class="s-button s-button-3 bg-2 border-color-2 color-white d-inline-block align-middle">
                                    <span class="align-middle color-white"><?php echo get_field( '_sogo_header_2_button2_txt', 'option' ); ?></span>
                                </a>
							<?php endif; ?>
							<div style="position: relative; top: 0px; border-right: 1px solid #c0c0c0; line-height: 20px" class="text-3 color-4 text-center d-inline-block pr-1 mr-1"><a class="color-4" href="tel:*3504">3504*</a></div>
                        </div>
                    </div>
                </div>

                <!-- MENU MOBILE -->
                <nav class="js-mobile-menu primary-menu primary-menu__hide py-1">
                    <div class="row  ">
                        <div class="col-12 col-lg-6 px-15">
							<?php
							wp_nav_menu( array(
								'theme_location' => 'primary_menu',
								'depth'          => 2,
								'container'      => false,
								'walker'         => new Sogo_Walker()
							) );
							?>
                        </div>
                    </div>
                </nav>

                <div class="col-auto pl-1 text-left">
                    <!-- MOBILE LOGO -->
                    <a href="<?php echo home_url(); ?>" class="d-inline-block"
                       title="ביטוח חובה">
                        <svg style="width: 80px; height: 40px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 47 21"><g fill-rule="evenodd" stroke-miterlimit="10" stroke-width=".96"><path fill="#0070c0" stroke="#0070c0" d="M466.117 409.833c23.457 0 42.447-18.458 42.447-41.157 0-22.699-18.99-41.078-42.447-41.078-23.457 0-42.527 18.38-42.527 41.078 0 22.7 19.07 41.157 42.527 41.157zm0 0" transform="matrix(.04896 0 0 -.04973 0 21.007)"></path><path fill="#00b0f0" stroke="#00b0f0" d="M508.644 312.36c23.457 0 42.526-18.379 42.526-41.078s-19.069-41.157-42.526-41.157c-23.538 0-42.527 18.458-42.527 41.157 0 22.7 18.99 41.079 42.527 41.079zm0 0" transform="matrix(.04896 0 0 -.04973 0 21.007)"></path><path fill="#0070c0" stroke="#0070c0" d="M17.314 279.608h65.904v-97.865h95.027v97.865h65.984V26.148h-65.984v105.484H83.218V26.148H17.314zm0 0M390.718 204.756c32.553 0 58.564-10.525 78.032-31.418 15.798-17.043 23.697-37.386 23.697-61.028 0-23.877-7.82-44.377-23.537-61.42-19.07-20.815-45.719-31.183-80.027-31.183-34.388 0-61.117 10.368-80.186 31.182-15.718 17.044-23.537 38.015-23.537 62.913 0 22.385 7.899 42.257 23.696 59.536 19.23 20.893 46.516 31.418 81.862 31.418zm-1.835-52.389c-12.527 0-22.82-4.712-30.638-14.137-6.463-7.62-9.655-16.259-9.655-25.92 0-9.818 3.192-18.536 9.655-26.155 7.819-9.425 18.111-14.138 30.638-14.138 11.25 0 20.745 3.849 28.484 11.625 7.74 7.776 11.649 17.358 11.649 28.668 0 11.153-3.91 20.657-11.729 28.433-7.819 7.776-17.314 11.624-28.404 11.624zm0 0M826.037 203.892c12.287 0 23.777-2.513 34.468-7.619 6.224-2.984 12.527-7.854 19.15-14.687v16.886h61.037V26.07h-61.038v19.165c-5.824-7.305-11.728-12.646-17.633-15.944-10.372-5.891-22.18-8.797-35.425-8.797-21.383 0-40.373 7.383-57.048 22.149-19.947 17.515-29.84 40.764-29.84 69.747 0 29.454 10.132 52.938 30.558 70.532 16.197 13.98 34.787 20.97 55.771 20.97zm16.277-52.546c-12.048 0-22.021-4.634-29.76-13.745-6.224-7.383-9.416-15.787-9.416-25.29 0-9.505 3.192-17.987 9.415-25.37 7.66-9.111 17.553-13.667 29.76-13.667 10.932 0 20.267 3.77 27.767 11.31 7.58 7.462 11.41 16.73 11.41 27.726 0 10.84-3.83 20.029-11.49 27.647-7.58 7.54-16.835 11.39-27.686 11.39zm0 0M506.729 198.472h68.537l41.17-88.361 41.41 88.361h68.138l-89.68-172.324h-40.612zm0 0" transform="matrix(.04896 0 0 -.04973 0 21.007)"></path></g>
                             alt="ביטוח חובה"
                             </svg>
                    </a>
                </div>

            </div>

		<?php else: ?>

            <!-- desktop-menu -->
            <!-- row -->
            <div class="row py-2 h-100 align-items-center menu-desktop-manipulation">

                <div class="col-lg pl-1 text-right">

                    <!-- row -->
                    <div class="row">

                        <div class="col-auto align-self-center px-15">
                            <!-- HOME -->
                            <a href="<?php echo home_url(); ?>" title="חובה"
                               class="icon-home-01 hover-2 transition color-6 d-inline-block align-middle mx-15"></a>
                        </div>


						<?php if ( '' != get_field( '_sogo_header_2_button1_link', 'options' ) ): ?>
                            <div class="col-auto align-self-center px-15">
                                <!-- COSTUMER SERVICE BUTTON -->
                                <a href="<?php echo esc_url( get_field( '_sogo_header_2_button1_link', 'option' ) ); ?>"
                                   class="s-button s-button-3 border-width-x1 border-color-6 color-2 d-inline-block bg-transparent align-middle"><?php echo get_field( '_sogo_header_2_button1_txt', 'option' ); ?></a>
                            </div>
						<?php endif; ?>


                        <div class="col-auto">
                            <!-- MENU -->
                            <nav class="primary-menu text-left d-inline-block align-middle">
								<?php
								wp_nav_menu( array(
									'theme_location' => 'primary_menu',
									'depth'          => 2,
									'container'      => false,
									'walker'         => new Sogo_Walker()
								) );
								?>
                            </nav>
                        </div>

                        <div class="col-auto align-self-center">
                            <!-- OFFER BUTTON -->
                            <a href="<?php echo esc_url( get_field( '_sogo_header_2_button2_link', 'option' ) ); ?>"
                               class="s-btn-1 bg-2 border-color-2 color-white d-inline-block align-middle mx-2">
                                <span><?php echo get_field( '_sogo_header_2_button2_txt', 'option' ); ?></span>
                                <span class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></span>
                            </a>
                        </div>
							<div style="border-right: 1px solid #c0c0c0; height: 30px" class="text-4 color-4 text-center d-inline-block pr-3 mr-2 align-self-center"><strong><a class="color-4" href="tel:*3504">3504*</a></strong></div>
                    </div>

                </div>

                <!-- LOGO -->
                <div class="col-lg-auto pl-15 text-left">
                    <a href="<?php echo home_url(); ?>" class="header-2__logo d-inline-block ml-15"
                       title="<?php echo __( 'Go to homepage', 'sogoc' ); ?>">
                        <svg style="width: 130px; height: 60px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 47 21"><g fill-rule="evenodd" stroke-miterlimit="10" stroke-width=".96"><path fill="#0070c0" stroke="#0070c0" d="M466.117 409.833c23.457 0 42.447-18.458 42.447-41.157 0-22.699-18.99-41.078-42.447-41.078-23.457 0-42.527 18.38-42.527 41.078 0 22.7 19.07 41.157 42.527 41.157zm0 0" transform="matrix(.04896 0 0 -.04973 0 21.007)"></path><path fill="#00b0f0" stroke="#00b0f0" d="M508.644 312.36c23.457 0 42.526-18.379 42.526-41.078s-19.069-41.157-42.526-41.157c-23.538 0-42.527 18.458-42.527 41.157 0 22.7 18.99 41.079 42.527 41.079zm0 0" transform="matrix(.04896 0 0 -.04973 0 21.007)"></path><path fill="#0070c0" stroke="#0070c0" d="M17.314 279.608h65.904v-97.865h95.027v97.865h65.984V26.148h-65.984v105.484H83.218V26.148H17.314zm0 0M390.718 204.756c32.553 0 58.564-10.525 78.032-31.418 15.798-17.043 23.697-37.386 23.697-61.028 0-23.877-7.82-44.377-23.537-61.42-19.07-20.815-45.719-31.183-80.027-31.183-34.388 0-61.117 10.368-80.186 31.182-15.718 17.044-23.537 38.015-23.537 62.913 0 22.385 7.899 42.257 23.696 59.536 19.23 20.893 46.516 31.418 81.862 31.418zm-1.835-52.389c-12.527 0-22.82-4.712-30.638-14.137-6.463-7.62-9.655-16.259-9.655-25.92 0-9.818 3.192-18.536 9.655-26.155 7.819-9.425 18.111-14.138 30.638-14.138 11.25 0 20.745 3.849 28.484 11.625 7.74 7.776 11.649 17.358 11.649 28.668 0 11.153-3.91 20.657-11.729 28.433-7.819 7.776-17.314 11.624-28.404 11.624zm0 0M826.037 203.892c12.287 0 23.777-2.513 34.468-7.619 6.224-2.984 12.527-7.854 19.15-14.687v16.886h61.037V26.07h-61.038v19.165c-5.824-7.305-11.728-12.646-17.633-15.944-10.372-5.891-22.18-8.797-35.425-8.797-21.383 0-40.373 7.383-57.048 22.149-19.947 17.515-29.84 40.764-29.84 69.747 0 29.454 10.132 52.938 30.558 70.532 16.197 13.98 34.787 20.97 55.771 20.97zm16.277-52.546c-12.048 0-22.021-4.634-29.76-13.745-6.224-7.383-9.416-15.787-9.416-25.29 0-9.505 3.192-17.987 9.415-25.37 7.66-9.111 17.553-13.667 29.76-13.667 10.932 0 20.267 3.77 27.767 11.31 7.58 7.462 11.41 16.73 11.41 27.726 0 10.84-3.83 20.029-11.49 27.647-7.58 7.54-16.835 11.39-27.686 11.39zm0 0M506.729 198.472h68.537l41.17-88.361 41.41 88.361h68.138l-89.68-172.324h-40.612zm0 0" transform="matrix(.04896 0 0 -.04973 0 21.007)"></path></g>
                             alt="ביטוח חובה"
                             </svg>
                    </a>
                </div>

            </div>

            <!-- mobile-menu -->
            <!-- row -->
            <div class="row justify-content-between py-2 align-items-center menu-mobile-manipulation d-none">

                <div class="col-auto px-15">

                    <!-- row -->
                    <div class="row align-items-center">

                        <div class="col-auto px-15">
                            <!-- STRIPES -->
                            <div class="stripes-menu d-block">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>

                        <div class="col-auto px-15">
                            <!-- MOBILE OFFER BUTTON -->
                            <a href="<?php echo get_field( '_sogo_header_2_button2_link', 'options' ); ?>"
                               class="s-button s-button-3 bg-2 border-color-2 color-white d-inline-block align-middle">
                                <span class="align-middle color-white "><?php echo get_field( '_sogo_header_2_button2_txt', 'option' ); ?></span>
                                <span class="icon-arrowleft-01 color-white icon-sm d-inline-block align-middle"></span>
                            </a>
                        </div>
							<div style="border-right: 1px solid #c0c0c0; height: 20px" class="text-4 color-4 text-center d-inline-block pr-2 mr-1 align-self-center"><strong><a class="color-4" href="tel:*3504">3504*</a></strong></div>
                    </div>

                </div>

                <!-- MOBILE MENU  -->
                <nav class="js-mobile-menu primary-menu primary-menu__hide py-1">
                    <div class="row  ">
                        <div class="col-12 col-lg-6 px-15">
							<?php
							wp_nav_menu( array(
								'theme_location' => 'primary_menu',
								'depth'          => 2,
								'container'      => false,
								'walker'         => new Sogo_Walker()
							) );
							?>
                        </div>
                    </div>
                </nav>

                <div class="col-auto px-15 text-left">
                    <!-- MOBILE LOGO -->
                    <a href="<?php echo home_url(); ?>" class="d-inline-block"
                       title="ביטוח חובה">
                        <svg style="width: 80px; height: 40px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 47 21"><g fill-rule="evenodd" stroke-miterlimit="10" stroke-width=".96"><path fill="#0070c0" stroke="#0070c0" d="M466.117 409.833c23.457 0 42.447-18.458 42.447-41.157 0-22.699-18.99-41.078-42.447-41.078-23.457 0-42.527 18.38-42.527 41.078 0 22.7 19.07 41.157 42.527 41.157zm0 0" transform="matrix(.04896 0 0 -.04973 0 21.007)"></path><path fill="#00b0f0" stroke="#00b0f0" d="M508.644 312.36c23.457 0 42.526-18.379 42.526-41.078s-19.069-41.157-42.526-41.157c-23.538 0-42.527 18.458-42.527 41.157 0 22.7 18.99 41.079 42.527 41.079zm0 0" transform="matrix(.04896 0 0 -.04973 0 21.007)"></path><path fill="#0070c0" stroke="#0070c0" d="M17.314 279.608h65.904v-97.865h95.027v97.865h65.984V26.148h-65.984v105.484H83.218V26.148H17.314zm0 0M390.718 204.756c32.553 0 58.564-10.525 78.032-31.418 15.798-17.043 23.697-37.386 23.697-61.028 0-23.877-7.82-44.377-23.537-61.42-19.07-20.815-45.719-31.183-80.027-31.183-34.388 0-61.117 10.368-80.186 31.182-15.718 17.044-23.537 38.015-23.537 62.913 0 22.385 7.899 42.257 23.696 59.536 19.23 20.893 46.516 31.418 81.862 31.418zm-1.835-52.389c-12.527 0-22.82-4.712-30.638-14.137-6.463-7.62-9.655-16.259-9.655-25.92 0-9.818 3.192-18.536 9.655-26.155 7.819-9.425 18.111-14.138 30.638-14.138 11.25 0 20.745 3.849 28.484 11.625 7.74 7.776 11.649 17.358 11.649 28.668 0 11.153-3.91 20.657-11.729 28.433-7.819 7.776-17.314 11.624-28.404 11.624zm0 0M826.037 203.892c12.287 0 23.777-2.513 34.468-7.619 6.224-2.984 12.527-7.854 19.15-14.687v16.886h61.037V26.07h-61.038v19.165c-5.824-7.305-11.728-12.646-17.633-15.944-10.372-5.891-22.18-8.797-35.425-8.797-21.383 0-40.373 7.383-57.048 22.149-19.947 17.515-29.84 40.764-29.84 69.747 0 29.454 10.132 52.938 30.558 70.532 16.197 13.98 34.787 20.97 55.771 20.97zm16.277-52.546c-12.048 0-22.021-4.634-29.76-13.745-6.224-7.383-9.416-15.787-9.416-25.29 0-9.505 3.192-17.987 9.415-25.37 7.66-9.111 17.553-13.667 29.76-13.667 10.932 0 20.267 3.77 27.767 11.31 7.58 7.462 11.41 16.73 11.41 27.726 0 10.84-3.83 20.029-11.49 27.647-7.58 7.54-16.835 11.39-27.686 11.39zm0 0M506.729 198.472h68.537l41.17-88.361 41.41 88.361h68.138l-89.68-172.324h-40.612zm0 0" transform="matrix(.04896 0 0 -.04973 0 21.007)"></path></g>
                             alt="ביטוח חובה"
                             </svg>
                    </a>
                </div>

            </div>

		<?php endif; ?>
    </div>
</header>


<div id="page">