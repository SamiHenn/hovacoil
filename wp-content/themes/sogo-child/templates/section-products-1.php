<?php
$title = get_field('_sogo_section-products-1_title');
$sub_title = get_field('_sogo_section-products-1_sub_title');
$products = '_sogo_section-products-1_products';
$bg_color = get_field('_sogo_section_products_1_bg_color');
$bg_img = get_field('_sogo_section_products_1_bg_image');
$icon_size = wp_is_mobile() ? 'icon-x5' : 'icon-x6';
?>


<section class="section-products-1 p-relative pt-3 pt-lg-5"
         style="background-color: <?php echo $bg_color; ?>;background-image: url('<?php echo $bg_img; ?>');">
    <div class="container-fluid">

        <!-- SECTION-PRODUCTS-1 TITLE -->
        <div class="row text-center mb-3 mb-lg-4">
            <div class="col-12 mb-lg-2">
                <h3 class="text-2 color-4"><?php echo $title; ?> </h3>
            </div>
            <div class="col-12">
                <span class="text-3 color-6"><?php echo $sub_title; ?> </span>
            </div>
        </div>

        <!-- SECTION-PRODUCTS-1 PRODUCTS -->
        <?php if (have_rows($products)) : ?>
            <div class="row justify-content-center pb-4">
                <div class="col-lg-8">
                    <div class="row justify-content-center">

                        <?php while (have_rows($products)) : the_row() ?>
                            <?php
                            $icon = get_sub_field('icon');
                            $icon_color = get_sub_field('icon_color');
                            $text = get_sub_field('text');
                            ?>
                            <div class="col-6 col-lg-3 section-products-1__box text-center">
                            <a href="<?php the_sub_field('link') ?>">
                                <i class="<?php echo $icon . '-' . $icon_color; ?> <?php echo $icon_size; ?>  mx-auto mb-1 bg-position-center rotate-y-360-on-hover"></i>
                                <span class="text-4 color-6"><?php echo $text; ?> </span>
                            </a>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </div>

            </div>
        <?php endif; ?>

    </div>

    <div class="section-products-1__object-wrapper w-100 b-0">
        <img src="<?php echo get_field('_sogo_main_section_1_object_img')['url']; ?>" class="data-animation-3"
             alt="<?php echo get_field('_sogo_main_section_1_object_img')['alt']; ?>" data-animation>
    </div>
</section>

