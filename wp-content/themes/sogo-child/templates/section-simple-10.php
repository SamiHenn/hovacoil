<?php
$circle_justify = wp_is_mobile() ? 'justify-content-between justify-content-md-around' : 'justify-content-center';
$circle_margin_x = wp_is_mobile() ? '' : 'mx-4';
$circle_margin_b = wp_is_mobile() ? 'mb-3' : 'mb-5';
$check_size = wp_is_mobile() ? 'icon-x2' : 'icon-x3';
$facts_margin_b = wp_is_mobile() ? 'mb-2' : 'mb-4';
$icon_size = wp_is_mobile() ? 'icon-x4' : 'icon-x6';
$title_display = wp_is_mobile() ? 'd-inline-block' : 'd-block';
$icon_wrap = wp_is_mobile() ? 'p-1' : 'p-3';
?>

<section class="section-simple-10 p-relative py-4 py-lg-5 bg-white">
    <div class="container-fluid px-0">
        <!-- SECTION SIMPLE 10 TITLE -->
        <?php if (get_field('_sogo_section_simple_10_title')) : ?>
            <div class="row section-simple-10__title">
                <div class="col-12 text-center">
                    <h3 class="color-4 text-slider"><?php echo get_field('_sogo_section_simple_10_title'); ?></h3>
                </div>
            </div>
        <?php endif; ?>

        <!-- SECTION SIMPLE 10 FACTS -->
        <?php if (have_rows('_sogo_section_simple_10_steps')) : ?>
            <?php
            $field_object = get_field_object('_sogo_section_simple_10_steps');
            $total_rows = count($field_object['value']);
            ?>
            <div class="row mx-15 justify-content-md-center">
                <?php $counter = 0; ?>
                <?php while (have_rows('_sogo_section_simple_10_steps')) : the_row() ?>
                    <?php
                    $counter++;
                    $fact_margin_bottom = $total_rows == $counter ? '' : 'mb-2';
                    ?>
                    <div class="col-md-3 col-lg-2 section-simple-10__icon-wrapper px-md-15 text-right text-md-center">
                        <div class="row align-items-center">
                            <div class="col-auto mx-md-auto mb-md-2">
                                <div class="border b-radius-50 rotate-y-360-on-hover <?php echo $icon_wrap; ?> "
                                     style="border-color: <?php the_sub_field('color') ?>">
                                    <i class="<?php the_sub_field('icon'); ?> <?php echo $icon_size; ?> mx-auto bg-position-center"></i>
                                </div>
                            </div>
                            <div class="col col-md-12">
                                <div class="">
                                <span class="<?php echo $title_display; ?> text-3 mb-md-1"
                                      style="color: <?php the_sub_field('color') ?>"><?php the_sub_field('title'); ?></span>
                                    <p class="text-p color-6 align-middle p-height">
                                        <?php the_sub_field('text'); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>

    </div>
</section>