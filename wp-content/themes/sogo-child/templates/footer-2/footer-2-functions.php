<?php

/**
 * script enqueue
 */
function sogo_footer_2_enqueue() {
	return wp_enqueue_script( 'sogo-child-footer-2', get_stylesheet_directory_uri() . '/templates/footer-2/footer-2.js', array( 'jquery' ), uniqid(), true );
}

add_action( 'wp_enqueue_scripts', 'sogo_footer_2_enqueue',10 );


/**
 * widgets
 */
function sogo_footer_2_widgets() {
	register_sidebar( array(
		'name'          => __( 'Footer 1', 'sogoc' ),
		'id'            => 'footer1',
		'before_widget' => '<aside class="widget">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title color-white text-6 medium d-inline-block align-middle p-relative"><span class="mx-1 mx-lg-0">',
		'after_title'   => '</span></h3><span class="js-footer-arrow icon-arrowdown-01 align-middle color-white icon-xxs hidden-lg-up cursor-pointer mx-1"></span>'
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 2', 'sogoc' ),
		'id'            => 'footer2',
		'before_widget' => '<aside class="widget">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title color-white text-6 medium d-inline-block align-middle p-relative"><span class="mx-1 mx-lg-0">',
		'after_title'   => '</span></h3><span class="js-footer-arrow icon-arrowdown-01 align-middle color-white icon-xxs hidden-lg-up cursor-pointer mx-1"></span>'
	) );
	register_sidebar( array(
		'name'          => __( 'Footer 3', 'sogoc' ),
		'id'            => 'footer3',
		'before_widget' => '<aside class="widget">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title color-white text-6 medium d-inline-block align-middle p-relative"><span class="mx-1 mx-lg-0">',
		'after_title'   => '</span></h3><span class="js-footer-arrow icon-arrowdown-01 align-middle color-white icon-xxs hidden-lg-up cursor-pointer mx-1"></span>'
	) );
}

add_action( 'widgets_init', 'sogo_footer_2_widgets', 11 );