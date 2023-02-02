<?php
$text = get_field('_sogo_section_simple_11_text');
$button_text = get_field('_sogo_section_simple_11_button_text');
$button_link = get_field('_sogo_section_simple_11_button_link');
$bg = get_field('_sogo_section_simple_11_bg');
$title_mt = wp_is_mobile() ? 'mt-1' : 'mt-5';
$button_mb = wp_is_mobile() ? 'mb-1' : 'mb-5';
$section_py = wp_is_mobile() ? '' : 'py-5';
$button = wp_is_mobile() ? 's-btn-4' : 's-btn-4';
?>

<section class="section-simple-11 p-relative py-5 px-3 bg-3"
         style="background-image: url('<?php echo $bg; ?>');">
    <div class="container-fluid">
        <div class="row text-center justify-content-center">

            <!-- SECTION SIMPLE 11 TEXT -->
            <div class="col-12 mb-3 <?php echo $title_mt; ?> mb-lg-5">
                <span class="text-slider color-white d-block"><?php echo $text; ?></span>
            </div>

            <!-- SECTION SIMPLE 11 BUTTON -->
            <div class="col-lg-2 <?php echo $button_mb; ?>">
                <a href="<?php echo $button_link; ?>"
                   class="s-btn-3 <?php echo $button; ?>"><?php echo $button_text; ?>
                </a>
            </div>
        </div>


    </div>
</section>