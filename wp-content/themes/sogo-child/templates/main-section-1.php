<?php
$bg_img_desktop = get_field( '_sogo_main_section_1_bg_img_desktop' );
$bg_img_mobile  = get_field( '_sogo_main_section_1_bg_img_mobile' );

$bg          = wp_is_mobile() ? $bg_img_mobile : $bg_img_desktop;
$carWidth_img_mobile = 61;	
$carWidth_img_desktop = 122;	
$carHeight_img_mobile = 37;	
$carHeight_img_desktop = 74;	
$carWidth          = wp_is_mobile() ? $carWidth_img_mobile : $carWidth_img_desktop;	
$carHeight          = wp_is_mobile() ? $carHeight_img_mobile : $carHeight_img_desktop;
?>

<section class="main-section-1 p-relative"
         style="background-image: url('<?php echo $bg; ?>'); ">
    <div class="container-fluid">
        <div class="row justify-content-center">
					<!--- מ כאן -->
			<style> 
#clouds {
  background: url(https://www.hova.co.il/wp-content/uploads/2020/01/clouds.png) repeat 0 0;
  width: 100%;
  height: 209px;
  -webkit-animation: slide 150s linear infinite;
	position: absolute;
	top: 50px;
	left: 0px;
}
@media only screen and (max-width: 600px) {
#clouds {
  background: url(https://www.hova.co.il/wp-content/uploads/2020/01/clouds.png) repeat 0 0;
  width: 100%;
  height: 209px;
  -webkit-animation: slide 30s linear infinite;
	position: absolute;
	top: 10px;
	left: 0px;
  }
  }
/* Safari 4.0 - 8.0 */
@-webkit-keyframes slide {
    from { background-position: 0 0; }
    to { background-position: 2876px 0; }
}

/* Standard syntax */
@keyframes slide {
    from { background-position: 0 0; }
    to { background-position: 2876px 0; }
}
</style>
<div id="clouds"></div>
			<!--- עד כאן -->
            <div class="col-lg-6 text-center mb-2 mb-lg-4 pt-1 pt-lg-5">
                <span class="text-slider color-6 d-block mb-1 mb-lg-3"><?php echo get_field( '_sogo_main_section_1_text_1' ); ?></span>
                <span class="d-block text-1 color-4"><?php echo get_field( '_sogo_main_section_1_text_2' ); ?> </span>
            </div>
            <div class="col-xl-10 col-xxl-8 text-center">

                    <a  href="<?php echo get_field( '_sogo_main_section_1_button_1_link' ); ?><?php //echo $ins_order_link;?>"
                       class="s-button s-button-1 bg-5 border-color-5 custom-slider-button mx-2 d-block d-lg-inline-block mb-2 mb-lg-3">
						<?php echo get_field( '_sogo_main_section_1_button_1_text' ); ?>
                    </a>

                    <a  href="<?php echo get_field( '_sogo_main_section_1_button_2_link' ); ?><?php //echo $ins_order_link;?>"
                       class="s-button s-button-1 bg-4 border-color-4 custom-slider-button mx-2 d-block d-lg-inline-block mb-2 mb-lg-3">
						<?php echo get_field( '_sogo_main_section_1_button_2_text' ); ?>
                    </a>

                    <a href="<?php echo get_field( '_sogo_main_section_1_button_3_link' ); ?><?php //echo $ins_order_link;?>"
                       class="s-button s-button-1 bg-3 border-color-3 custom-slider-button mx-2 d-block d-lg-inline-block mb-2 mb-lg-3 px-lg-5">
						<?php echo get_field( '_sogo_main_section_1_button_3_text' ); ?>
                    </a>
				<div class="col-lg-12"><a class="text-5 color-black d-inline-block align-middle mt-2 col-auto px-3 text-center" style="background-color: #ffffff; text-decoration: none; line-height: 45px; border-radius: 35px" href="https://www.hova.co.il/bdikatik/" rel="noopener">בדיקת תיק ביטוחי <img src="https://www.hova.co.il/wp-content/uploads/2022/12/search-40.gif" width="40px" height="40px"></a></div>
            </div>
        </div>
    </div>

    <div class="main-section-1__object-wrapper p-absolute w-100 b-0">
        <img height="<?php echo $carHeight; ?>" width="<?php echo $carWidth; ?>" src="<?php echo get_field( '_sogo_main_section_1_object_img' )['url']; ?>"
             class="data-animation-1"
             alt="<?php echo get_field( '_sogo_main_section_1_object_img' )['alt']; ?>"
             data-animation>
    </div>
</section>