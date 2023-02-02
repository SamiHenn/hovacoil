<?php
$title = get_field('_sogo_section_select_1_title');
$text = get_field('_sogo_section_select_1_text');
$insurance_products = '_sogo_section_select_1_insurance_products';
$button_text = get_field('_sogo_section_select_1_button_text');
$bg_color = get_field('_sogo_section_select_1_bg_color');
$icon_size = wp_is_mobile() ? 'icon-x3' : 'icon-x4';
?>

<section class="section-select-1 p-relative py-4 py-lg-5"
         style="background-color: <?php echo $bg_color; ?>">
    <div class="container-fluid px-0">
        <!-- SECTION-SELECT-1 TITLE -->
        <div class="row text-center mb-3 mb-lg-4">
            <div class="col-12 mb-lg-2">
                <h3 class="text-2 color-white"><?php echo $title; ?> </h3>
            </div>
            <div class="col-12">
                <span class="text-3 color-white"><?php echo $text; ?> </span>
            </div>
        </div>

        <div class="row justify-content-center mb-lg-1">

            <!-- SECTION-SELECT-1 SELECT -->
            <div class="col-10 col-lg-6 mb-3 mb-lg-0">
                <select id="insurance-products" name="insurance-products" class="ddl"
                        title="insurance-products">
                    <?php while (have_rows($insurance_products)) : the_row() ?>
                        <?php
                        $icon_color = get_sub_field('icon_color');
                        $icon = get_sub_field('icon');
                        ?>
                        <option value="<?php the_sub_field('product_name'); ?>"
                                data-icon="<?php echo $icon . '-' . $icon_color; ?> <?php echo $icon_size; ?> "
                                data-url="<?php the_sub_field('link'); ?>">
                            <?php the_sub_field('product_name'); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- SECTION-SELECT-1 BUTTON -->
            <div class="col-10 col-lg-3 col-xxl-2">
                <a href="#" class="s-button s-button-4" id="go-to-product"><?php echo $button_text; ?></a>
            </div>
        </div>

    </div>
</section>

