<?php
/*
 *  This file handle only enqueue scripts and style for the parent theme
 * expose:
 *  add_action( 'wp_enqueue_scripts', 'sogo_load_fancybox' );
 *  add_action( 'wp_enqueue_scripts', 'sogo_load_lightbox' );
 * */
function sogo_scripts() {
	if ( ! is_admin() ) {
		// enqueue to header
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'tether', get_template_directory_uri() . '/assets/js/tether.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'popper', get_template_directory_uri() . '/assets/js/popper.min.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array( 'jquery' ), '', true );

		// Enable threaded comments
		if ( ( ! is_admin() ) && is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_localize_script( 'bootstrap', 'sogo', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );

	}
}

add_action( 'wp_enqueue_scripts', 'sogo_scripts' );


/*
  Engeue styles
--------------------------------------------*/


/*
  Engeue styles
--------------------------------------------*/

function sogo_styles() {
	if ( ! is_admin() ) {
		wp_enqueue_style( 'bootstrap-responsive', get_template_directory_uri() . '/assets/css/bootstrap.css', array(), '', 'all' );
//		if(is_rtl()){
//			wp_enqueue_style( 'bootstrap-responsive-rtl', get_template_directory_uri() . '/assets/css/bootstrap.rtl.min.css', array(), '', 'all' );
//		}
	//	if ( USE_FONTAWSOME ) {
	//		wp_enqueue_style( 'fontawsome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), '', 'all' );
//	}
	//	if ( USE_ANIMATION ) {
			wp_enqueue_style( 'sogo-animation', get_template_directory_uri() . '/assets/css/animate.min.css', array(), '', 'all' );
	//	}
	}
}

add_action( 'wp_enqueue_scripts', 'sogo_styles', 1 );

/*
 * load fancybox script
 * usage: add_action( 'wp_enqueue_scripts', 'sogo_load_fancybox' );
*/
function sogo_load_fancybox() {
	if ( ! is_admin() ) {
		wp_enqueue_style( 'fancybox-css', get_template_directory_uri() . '/assets/js/fancybox/jquery.fancybox.min.css', array(), '', 'all' );
		wp_enqueue_script( 'fancybox', get_template_directory_uri() . '/assets/js/fancybox/jquery.fancybox.pack.js', array( 'jquery' ), '', true );
		wp_enqueue_script( 'fancybox-media', get_template_directory_uri() . '/assets/js/fancybox/helpers/jquery.fancybox-media.min.js', array( 'jquery' ), '', true );
	}
}

/*
 * load fancybox script
 * usage: add_action( 'wp_enqueue_scripts', 'sogo_load_lightbox' );
*/
function sogo_load_lightbox() {
	wp_enqueue_script( 'sogolight', get_template_directory_uri() . '/assets/js/lightbox/ekko-lightbox.min.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'sogolightcss', get_template_directory_uri() . '/assets/js/lightbox/ekko-lightbox.min.css', array(), '', 'all' );
}


/*
 * load fancybox script
 * usage: add_action( 'wp_enqueue_scripts', 'sogo_load_fullPage' );
*/
function sogo_load_fullPage() {
//    wp_enqueue_script('slimscroll', get_template_directory_uri() . '/assets/js/fullpage/jquery.slimscroll.min.js', array('jquery'), '',true);
	wp_enqueue_script( 'fullPage', 'https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.7.8/jquery.fullPage.min.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'fullPagecss', get_template_directory_uri() . '/assets/js/fullpage/jquery.fullPage.css', array(), '', 'all' );

}

/*
 * load ScrollMagic script
 * usage: add_action( 'wp_enqueue_scripts', 'sogo_load_lightbox' );
*/
function sogo_load_ScrollMagic() {
	//wp_enqueue_script('slimscroll', get_template_directory_uri() . '/assets/js/fullpage/jquery.slimscroll.min.js', array('jquery'), '',true);
	wp_enqueue_script( 'ScrollMagic', '//cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.5/ScrollMagic.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'TweenMax', '//cdnjs.cloudflare.com/ajax/libs/gsap/1.14.2/TweenMax.min.js', array( 'jquery' ), '', true );

}

/*
 * load fancybox script
 * usage: add_action( 'wp_enqueue_scripts', 'sogo_load_lightbox' );
*/
function sogo_load_parallax() {
	wp_enqueue_script( 'parallax', get_template_directory_uri() . '/assets/js/parallax/jquery.parallax.min.js', array( 'jquery' ), '', true );

}/*
 * load light gallery script
*/
function sogo_load_lightGallery() {
	wp_enqueue_script( 'lightGallery', get_template_directory_uri() . '/assets/js/lightGallery/lightgallery.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'lightGallery_fullscreen', get_template_directory_uri() . '/assets/js/lightGallery/lg-fullscreen.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'lightGallery_video', get_template_directory_uri() . '/assets/js/lightGallery/lg-video.js', array( 'jquery' ), '', true );
	wp_enqueue_style( 'lightGallery_css', get_template_directory_uri() . '/assets/js/lightGallery/lightgallery.css', array(), '', 'all' );

}


function sogo_load_jasnyBootstrap() {
	wp_enqueue_script( 'jasny-bootstrap-js', get_template_directory_uri() . '/assets/js/jasny-bootstrap/js/jasny-bootstrap.js', array( 'jquery' ), '', true );
}

function sogo_load_waypoint() {
	wp_enqueue_script( 'waypoint', get_template_directory_uri() . '/assets/js/waypoint/lib/jquery.waypoints.min.js', array( 'jquery' ), '', true );
}

function sogo_load_slickSlider() {
	wp_enqueue_style( 'slickslider', get_template_directory_uri() . '/assets/vendor/slick/slick.css', array(), '', 'all' );
	wp_enqueue_script( 'slickslider', get_template_directory_uri() . '/assets/vendor/slick/slick.min.js', array( 'jquery' ), '2', true );
}


function sogo_load_owl() {

	wp_register_script( 'owl-carousel-js', get_template_directory_uri() . '/assets/vendor/owl-carousel/owl.carousel.min.js', array( 'jquery' ), '', true );
	wp_enqueue_script( 'owl-carousel-js' );

	// Register and Add css file
	wp_register_style( 'owl-carousel', get_template_directory_uri() . '/assets/vendor/owl-carousel/owl.carousel.css', null,'');
	wp_enqueue_style( 'owl-carousel' );

}

/*
 * load js scrollbar
 * usage: add_action( 'wp_enqueue_scripts', 'sogo_load_scrollbar' );
*/
function sogo_load_scrollbar() {

    wp_register_script( 'js-scrollbar-js', get_template_directory_uri() . '/assets/vendor/js-scrollbar/jquery.mCustomScrollbar.concat.min.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'js-scrollbar-js' );
    wp_register_script( 'js-scrollbar-sogo', get_stylesheet_directory_uri() . '/js/scrollbar.js', array( 'jquery' ), '', true );
    wp_enqueue_script( 'js-scrollbar-sogo' );
    // Register and Add css file
    wp_register_style( 'js-scrollbar', get_template_directory_uri() . '/assets/vendor/js-scrollbar/jquery.mCustomScrollbar.css', null,'');
    wp_enqueue_style( 'js-scrollbar' );

}
