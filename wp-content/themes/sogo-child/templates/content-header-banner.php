<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 26-Mar-17
 * Time: 10:19 AM
 */
$image = '';

if ( is_page() ) {
	$image = get_the_post_thumbnail_url();
} elseif ( is_single() ) {
	$type = get_post_type();
//    debug($type);
//	$image = get_field( '_sogo_banner_single_' . $type, 'option' );
	$image = get_the_post_thumbnail_url();
} elseif ( is_archive() || is_home() ) {
	$type = get_post_type();
//	debug( $type );
	$image = get_field( '_sogo_banner_archive_' . $type, 'option' );
} elseif ( is_404() ) {
	$image = get_field( '_sogo_404_banner', 'option' );
}

if ( wp_is_mobile() ) {
	if ( get_field( '_sogo_banner_mobile' ) ) {
		$image = get_field( '_sogo_banner_mobile' );
	}
}


//elseif ( is_product_category() ){
//    global $wp_query;
//    $cat = $wp_query->get_queried_object();
//    $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
//    $image = wp_get_attachment_url( $thumbnail_id );
//}


if ( $image ):
	?>
    <section class="page-banner">
        <img src="<?php echo $image; ?>" alt="banner" class="img-fluid w-100">
    </section>
<?php endif; ?>


