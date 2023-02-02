<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 20-Jun-17
 * Time: 17:27 PM
 */





add_action( 'init', 'sogo_buttons' );
function sogo_buttons() {
	add_filter( "mce_external_plugins", "sogo_add_buttons" );
	add_filter( 'mce_buttons', 'sogo_register_buttons' );
}
function sogo_add_buttons( $plugin_array ) {
	$plugin_array['sogobtns'] = get_template_directory_uri() . '/lib/tinymce/clearfix.js';
	return $plugin_array;
}
function sogo_register_buttons( $buttons ) {
	array_push( $buttons, 'clearfix1'  ); // dropcap', 'recentposts
	return $buttons;
}

