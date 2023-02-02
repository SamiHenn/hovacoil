<?php
$title = get_field('_sogo_section_simple_12_title');
$sub_title = get_field('_sogo_section_simple_12_sub_title');
$buttons = '_sogo_section_simple_12_buttons';
$icon_size_1 = wp_is_mobile() ? 'icon-x5' : 'icon-x6';
$icon_size_2 = wp_is_mobile() ? 'icon-x6' : 'icon-x8';
?>

<section class="section-simple-12 p-relative py-4 py-lg-5 bg-white">
    <div class="container-fluid">

        <!-- SECTION-SIMPLE-12 TITLE -->
        <div class="row text-center mb-3 mb-lg-4">
            <div class="col-12 mb-lg-2">
                <h3 class="text-2 color-4"><?php echo $title; ?></h3>
            </div>
            <div class="col-12">
                <span class="text-3 color-6"><?php echo $sub_title; ?></span>
            </div>
        </div>

        <!-- SECTION-SIMPLE-12 BUTTONS -->
        <?php if (have_rows($buttons)) : ?>
            <div class="row justify-content-center align-items-center">
                <div class="col-10 col-lg-12">
                    <div class="row justify-content-center ">

                        <?php while (have_rows($buttons)) :
                            the_row() ?>
                            <?php
                            $button_size = get_sub_field('button_size');
                            $icon = get_sub_field('icon');
                            $icon_color = get_sub_field('icon_color');
                            $button_color = get_sub_field('button_color');
                            $button_link = get_sub_field('button_link');
                            $text = get_sub_field('text');
                            $small_text = get_sub_field('small_text');
                            ?>

                            <?php if ($button_size == 'small') : ?>
                            <div class="col-6 col-lg-2 text-center mb-2 mb-lg-0 px-1 px-lg-2">
                                <a href="<?php echo $button_link; ?>"
                                   class="d-block custom-border-radius px-2 py-1 px-lg-3 py-lg-4 h-100 d-lg-flex flex-lg-column"
                                   style="background-color:<?php echo $button_color ?>">
                                    <i class="<?php echo $icon . '-' . $icon_color . ' ' . $icon_size_1; ?> mx-auto mb-lg-2 bg-position-center"></i>
                                    <span class="text-4 color-white"><?php echo $text; ?></span>
                                </a>
                            </div>
                        <?php else : ?>

                            <div class="col-12 col-lg-4 text-center px-1 px-lg-2">
                                <a href="<?php echo $button_link; ?>"
                                   class="d-block custom-border-radius px-2 py-1 h-100 p-relative d-lg-flex align-items-lg-center justify-content-lg-center"
                                   style="background-color:<?php echo $button_color ?>">

                                    <i class="<?php echo $icon . '-' . $icon_color . ' ' . $icon_size_2; ?> mx-auto mx-lg-0  bg-position-center d-inline-block align-middle"></i>
                                    <div class="d-inline-block align-middle mr-2 text-right">
                                        <span class="text-4 color-white d-block align-middle mb-1"><?php echo $text; ?></span>
                                        <span class="text-5 color-white d-block align-middle"><?php echo $small_text; ?></span>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</section>