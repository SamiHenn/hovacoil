<?php

/**
 * language
 */
function wp_noshor_redefine_locale() {
	if ( ! is_admin() ):
		switch_to_locale( 'he_IL' );
	endif;
}

add_filter( 'init', 'wp_noshor_redefine_locale' );

$wp_locale->text_direction = 'rtl';

/**
 * script enqueue
 */
function sogo_header_2_enqueue() {
	return wp_enqueue_script( 'sogo-child-header-2', get_stylesheet_directory_uri() . '/templates/header-2/header-2.js', array( 'jquery' ), uniqid(), true );
}

add_action( 'wp_enqueue_scripts', 'sogo_header_2_enqueue' );


/**
 * acf menu
 */
function sogo_header_2_acf_option() {
	if ( function_exists( 'acf_add_options_page' ) ) {

		acf_add_options_sub_page(
			array(
				'page_title'  => 'Header',
				'menu_title'  => 'Header',
				'parent_slug' => 'theme-general-settings',
			)
		);
	}

}

add_action( 'acf/init', 'sogo_header_2_acf_option' );


/**
 * menu item arrow
 */
class Sogo_Walker extends Walker_Nav_Menu {

	function end_el( &$output, $item, $depth = 0, $args = array() ) {

		if ( in_array( 'menu-item-has-children', $item->classes ) ) {
			$output .= "<span class='js-open-menu icon-arrowdown-01 align-middle icon-xxs color-6 mx-1 d-inline-block'></span></li>";
		} else {
			$output .= "</li>";
		}


	}
}