<?php
/*
 * available actions:
 *
 *  add_action('admin_init', 'redirect_user_on_role');
 *  sogo_get_paragraph()
 *  sogo_url_grabber()
 *  get_images()
 *  sogo_tax_first_level()
 *  sogo_get_youtube_thmb()
 *  sogo_youtube_thumbnail()
 *  sogo_term_meta()
 *  sogo_meta()
 *  sogo_image()
 *
 * */


/**
 * Return the P for  index found in the post content.
 *
 * @since sogo 1.0
 * @return string|bool URL or false when no link is present.
 */
function sogo_get_paragraph( $index ) {
	$content_by_p = preg_split( '/&nbsp;/is', get_the_content() );

	return ( isset( $content_by_p[ $index ] ) ) ? $content_by_p[ $index ] : "";
}

/**
 * Return the URL for the first link found in the post content.
 *
 * @since sogo 1.0
 * @return string|bool URL or false when no link is present.
 */
function sogo_url_grabber() {
	if ( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches ) ) {
		return false;
	}

	return esc_url_raw( $matches[1] );
}


/**
 * get_images
 *
 * @param int $pid
 * @param bool $feature_image
 */
function get_images( $pid, $feature_image = true ) {
	$args = array(
		'order'          => 'ASC',
		'orderby'        => 'menu_order',
		'post_type'      => 'attachment',
		'post_parent'    => $pid,
		'post_mime_type' => 'image',
		'post_status'    => null,
		'numberposts'    => - 1,
		'exclude'        => ( $feature_image ) ? - 1 : get_post_thumbnail_id( $pid ),

	);

	return $attachments = get_posts( $args );
}


/* WP Editor add font size and font */
function wp_editor_font_size_filter( $options ) {
	array_shift( $options );
	array_unshift( $options, 'fontsizeselect' );
	array_unshift( $options, 'fontselect' );
	array_unshift( $options, 'formatselect' );

	return $options;
}

add_filter( 'mce_buttons_2', 'wp_editor_font_size_filter' );


// This function return the first parent taxonomy
function sogo_tax_first_level( $term, $tax ) {
	if ( $term->parent == 0 ) {
		return $term;
	}
	$parent = get_term( $term->parent, $tax );

	return sogo_tax_first_level( $parent, $tax );
}


function sogo_get_youtube_thmb( $url ) {
	require_once( ABSPATH . WPINC . '/class-oembed.php' );
	$oembed = _wp_oembed_get_object();

	$provider = $oembed->get_provider( $url );
	$fetch    = $oembed->fetch( $provider, $url );

	$url      = $fetch->thumbnail_url;

	return $url;
}

function sogo_get_video_thumbnail( $id ) {
	$url = sogo_meta( 'video_thumbnail', $id );


	if ( $url == '' ) {
		$url = sogo_get_youtube_thmb( sogo_meta( 'video', $id ) );
		update_post_meta( $id, '_sogo_video_thumbnail', $url );
	}

	return $url;
}

function sogo_youtube_thumbnail( $id, $class = 'youtube-thumb' ) {
	$url = sogo_get_video_thumbnail( $id );

	return "<img class='$class' src='$url'/>";
}


function redirect_user_on_role() {
	global $current_user;
	get_currentuserinfo();

	//If login user role is Subscriber
	if ( $current_user->user_level < 10 && $_SERVER['PHP_SELF'] != '/wp-admin/admin-ajax.php' ) {
		wp_redirect( home_url() );
		exit;
	}
}


function sogo_term_meta( $key, $id ) {
	return get_tax_meta( $id, "_sogo_$key", true );
}

function sogo_meta( $key, $post_id = false ) {
	$id = ( ! $post_id ) ? get_the_ID() : $post_id;

	return get_post_meta( $id, "_sogo_$key", true );
}

function sogo_image( $key, $size = null ) {
	$value = esc_url( sogo_meta( $key ) );
	if ( $value == "" ) {
		return false;
	}
	$id = sogo_meta( $key . "_id" );
	sogo_print_image( $id, $value, $size );
}

function sogo_print_image( $id, $url, $size = null, $class = '' ) {
	if ( $size ) {
		$image_src = wp_get_attachment_image_src( $id, $size );
		$url       = isset( $image_src[0] ) ? $image_src[0] : $url;
	}
	$alt   = esc_attr( get_post_meta( $id, '_wp_attachment_image_alt', true ) );
	$title = esc_attr( get_the_title( $id ) );
	echo "<img  class='$class' src='$url' title='$title' alt='$alt'/>";
}


function sogo_bg( $img ) {
	$img = get_field( $img );
	if ( $img ) {
		echo sprintf( " style='background-image: url( %s ); background-repeat: no-repeat; height: %spx; '", $img['url'], $img['height'] );

	}

}


function sogo_get_post_id_by_name( $post_name, $post_type = 'post' ) {
	$post_ids = get_posts( array
	(
		'post_name'   => $post_name,
		'post_type'   => $post_type,
		'numberposts' => 1,
		'fields'      => 'ids'
	) );

	return array_shift( $post_ids );
}