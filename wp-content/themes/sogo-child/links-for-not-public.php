<?php
$bg_img_desktop = get_field( '_sogo_main_section_1_bg_img_desktop' );
$bg_img_mobile  = get_field( '_sogo_main_section_1_bg_img_mobile' );

$bg          = wp_is_mobile() ? $bg_img_mobile : $bg_img_desktop;
?>

<section class="main-section-1 p-relative"
         style="background-image: url('<?php echo $bg; ?>'); ">
    <div class="container-fluid">
        <div class="row justify-content-center">

            <div class="col-lg-6 text-center mb-2 mb-lg-4 pt-1 pt-lg-5">
                <span class="text-slider color-6 d-block mb-1 mb-lg-3"><?php echo get_field( '_sogo_main_section_1_text_1' ); ?></span>
                <span class="d-block text-1 color-4"><?php echo get_field( '_sogo_main_section_1_text_2' ); ?> </span>
            </div>
            <div class="col-xl-10 col-xxl-8 text-center">

                    <a  href="<?php echo get_field( '_sogo_main_section_1_button_1_link' ); ?><?php //echo $ins_order_link;?>"
                       class="s-button s-button-1 bg-5 border-color-5 custom-slider-button mx-2 d-block d-lg-inline-block mb-2 mb-lg-3 px-lg-5">
						<?php echo get_field( '_sogo_main_section_1_button_1_text' ); ?>
                    </a>

                    <a  href="<?php echo get_field( '_sogo_main_section_1_button_2_link' ); ?><?php //echo $ins_order_link;?>"
                       class="s-button s-button-1 bg-4 border-color-4 custom-slider-button mx-2 d-block d-lg-inline-block mb-2 mb-lg-3 px-lg-5">
						<?php echo get_field( '_sogo_main_section_1_button_2_text' ); ?>
                    </a>

                    <a href="<?php echo get_field( '_sogo_main_section_1_button_3_link' ); ?><?php //echo $ins_order_link;?>"
                       class="s-button s-button-1 bg-3 border-color-3 custom-slider-button mx-2 d-block d-lg-inline-block mb-2 mb-lg-3 px-lg-5">
						<?php echo get_field( '_sogo_main_section_1_button_3_text' ); ?>
                    </a>

            </div>
        </div>
    </div>

    <div class="main-section-1__object-wrapper p-absolute w-100 b-0">
        <img src="<?php echo get_field( '_sogo_main_section_1_object_img' )['url']; ?>"
             class="data-animation-1"
             alt="<?php echo get_field( '_sogo_main_section_1_object_img' )['alt']; ?>"
             data-animation>
    </div>
</section>