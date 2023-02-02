<?php
define( 'ROOT_PATH', get_stylesheet_directory_uri() );

include 'templates/header-2/header-2-functions.php';
include 'templates/footer-2/footer-2-functions.php';
include "insurance-api/otzar/lib/ozar_dira.php";
// use this array to add post type that will remove the cpt from the url.
const SOGO_CPT_IGNORE = array( 'supplier' );

#include( 'lib/functions_template/load_more.php' );

//function sogo_include(){}

include 'vehicle-db.php';
//include 'snapir.php';

function sogo_class_autoload() {

	$sogo_includes = array();
	$sogo_includes = sogo_main_class_autoload( $sogo_includes );
	foreach ( glob( dirname( __FILE__ ) . "/lib/class/*.php" ) as $filename ) {
		$sogo_includes[] = "lib/class/" . basename( $filename );
	}
	// parent function.
	sogo_include( $sogo_includes );

}

function sogo_child_theme_setup() {

	add_image_size( 'company-logo', 103, 50, true );


	// load child text domain
	load_child_theme_textdomain( 'sogoc', get_stylesheet_directory() . '/languages' );


	register_nav_menus( array(
		'slitelink_nav' => __( 'Site Link Footer', 'sogoc' )
	) );

	// load external files
	$sogo_includes = array(
		'lib/widget.php',   // Utility functions
		'lib/post-type-init.php',   // Utility functions

	);
	//parent function.
	sogo_include( $sogo_includes );
//	sogo_class_autoload();
	add_post_type_support( 'page', 'excerpt' );

	if ( function_exists( 'acf_add_options_page' ) ) {

		if ( function_exists( 'acf_add_options_page' ) ) {

			acf_add_options_page( array(
				'page_title' => 'Theme General Settings',
				'menu_title' => 'Theme Settings',
				'menu_slug'  => 'theme-general-settings',
				'capability' => 'edit_posts',
				'redirect'   => false
			) );

			acf_add_options_sub_page( array(
				'page_title'  => 'Theme General Settings',
				'menu_title'  => 'Upsales',
				'parent_slug' => 'theme-general-settings',
			) );

			acf_add_options_sub_page( array(
				'page_title'  => 'Theme Header Settings',
				'menu_title'  => 'Header',
				'parent_slug' => 'theme-general-settings',
			) );

			acf_add_options_sub_page( array(
				'page_title'  => 'Theme Footer Settings',
				'menu_title'  => 'Footer',
				'parent_slug' => 'theme-general-settings',
			) );

		}
	}
}

add_action( 'after_setup_theme', 'sogo_child_theme_setup' );


function sogo_child_scripts() {
	$ver = uniqid();
	if ( ! is_admin() ) {
		wp_enqueue_script( 'maps', '//maps.googleapis.com/maps/api/js?key=AIzaSyAEwmQCNdCiebMz6BYqCo3igAY-W6-N0uU', array( 'jquery' ), '', true );
//		wp_enqueue_script( 'jquery-ui-slider' );
		add_action( 'wp_enqueue_scripts', 'sogo_load_waypoint' );
		add_action( 'wp_enqueue_scripts', 'sogo_load_slickSlider' );
//		add_action( 'wp_enqueue_scripts', 'sogo_load_lightGallery' );
//		add_action( 'wp_enqueue_scripts', 'sogo_load_lightbox' );
		//     add_action('wp_enqueue_scripts', 'sogo_load_easypiechart');

		wp_enqueue_script( 'select2-full', get_stylesheet_directory_uri() . '/js/select2/select2.full.min.js', array( 'jquery' ), $ver, true );
	//	wp_enqueue_script( 'select2-enjs', get_stylesheet_directory_uri() . '/js/select2/en.js', array( 'jquery' ), $ver, true );
		wp_enqueue_script( 'select2-hejs', get_stylesheet_directory_uri() . '/js/select2/he.js', array( 'jquery' ), $ver, true );
		wp_enqueue_script( 'sogo-child-grunticon-loader', get_stylesheet_directory_uri() . '/js/grunticon.loader.js', '', $ver, false );
		wp_enqueue_script( 'sogo-child-locations', get_stylesheet_directory_uri() . '/js/locations.js', array( 'jquery' ), $ver, true );
		wp_enqueue_script( 'sogo-child-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array( 'jquery' ), $ver, true );
		wp_enqueue_script( 'sogo-child-insurance-page', get_stylesheet_directory_uri() . '/js/insurance-page.js', array( 'jquery' ), $ver, true );
		wp_enqueue_script( 'sogo-child-brand-slider-1', get_stylesheet_directory_uri() . '/js/brand-slider-1.js', array( 'jquery' ), $ver, true );
//		wp_enqueue_script( 'sogo-child-jquery-validate', get_stylesheet_directory_uri() . '/js/jquery-validation/dist/jquery.validate.js', array( 'jquery' ), $ver, true );
		wp_enqueue_script( 'sogo-child-jquery-ui', get_stylesheet_directory_uri() . '/js/jquery-ui/jquery-ui.js', array( 'jquery' ), $ver, true );
		wp_enqueue_script( 'sogo-child-jquery-validate', get_stylesheet_directory_uri() . '/js/jquery-validation/dist/jquery.validate.js', array( 'jquery' ), $ver, true );
		wp_enqueue_script( 'sogo-child-datepicker-he', get_stylesheet_directory_uri() . '/js/datepicker-he.js', array( 'jquery' ), $ver, true );
		wp_enqueue_script( 'sogo-child-validate', get_stylesheet_directory_uri() . '/js/validate.js', array( 'jquery' ), $ver, true );
		wp_enqueue_script( 'sogo-child-selectBoxIt', get_stylesheet_directory_uri() . '/js/selectBoxIt.js', array( 'jquery' ), $ver, true );
		wp_enqueue_script( 'sogo-child-moment-js', get_stylesheet_directory_uri() . '/js/moment.js', array( 'jquery' ), $ver, true );
//		wp_enqueue_style( 'bootstrap1', 'https://unpkg.com/bootstrap@latest/dist/css/bootstrap.min.css' );
//		wp_enqueue_style( 'vuecss', 'https://unpkg.com/bootstrap-vue@2.0.0-rc.14/dist/bootstrap-vue.css' );
        if(false){
	        wp_enqueue_script( 'polyfill', '//unpkg.com/@babel/polyfill@latest/dist/polyfill.min.js' );
	        wp_enqueue_script( 'vue', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js' );
	        wp_enqueue_script( 'vue-bootstrap', '//unpkg.com/bootstrap-vue@latest/dist/bootstrap-vue.min.js' );
	        wp_enqueue_script( 'vue-vee', '//cdn.jsdelivr.net/npm/vee-validate@latest/dist/vee-validate.js' );
        }


//		wp_enqueue_script( 'sogo-child-input-mask', 'https://s3-us-west-2.amazonaws.com/s.cdpn.io/3/masking-input.js', array( 'jquery' ), $ver, true );


		wp_localize_script( 'sogo-child-scripts', 'sogoc', array(
			'map_icon'        => get_stylesheet_directory_uri() . '/images/location.png',
			'grunt_directory' => get_stylesheet_directory() . '/images/grunticon/',
			'minDate'         => sogo_set_dates()
		) );

		wp_enqueue_style( 'google-fonts', 'https://fonts.googleapis.com/css?family=Rubik:300,400,500,700&amp;subset=hebrew' );

		wp_localize_script( 'sogo-child-scripts', 'sogo', array() );

		wp_enqueue_style( 'sogo-style', get_stylesheet_uri(), array(), $ver );
		wp_enqueue_style( 'sogo-jquery-ui-css', get_stylesheet_directory_uri() . '/js/jquery-ui/jquery-ui.css', '', $ver );
		wp_enqueue_style( 'sogo-select2-css', get_stylesheet_directory_uri() . '/select2.min.css', '', $ver );
	}

}


/**
 * acf options pages
 */
function sogo_acf_init() {
	if ( function_exists( 'acf_add_options_page' ) ) {

		acf_add_options_page(
			array(
				'page_title' => __( 'Theme General Settings', 'sogoc' ),
				'menu_title' => __( 'Theme Settings', 'sogoc' ),
				'menu_slug'  => 'theme-general-settings',
				'capability' => 'edit_posts',
				'redirect'   => false
			) );
		acf_add_options_sub_page(
			array(
				'page_title'  => '404-Settings',
				'sogoc',
				'menu_title'  => __( '404', 'sogoc' ),
				'parent_slug' => 'theme-general-settings',
			)
		);
	}
}

add_action( 'acf/init', 'sogo_acf_init' );


function sogo_enque_facebock_comment_script() { ?>

    <div id="fb-root"></div>
    <script>(function (d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/he_IL/sdk.js#xfbml=1&version=v2.5";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>

<?php }


add_action( 'wp_enqueue_scripts', 'sogo_child_scripts', 2 );

function sogo_extra_class( $key ) {
	$val = sogo_meta( $key );
	if ( $val != - 1 ) {
		echo $val;
	}
}

//Add car models menu to upload excel file with car data
/////
add_action( 'admin_menu', 'admin_menu' );

function admin_menu() {
	add_menu_page( 'Car Models', 'Car models', 'read', 'car-models', 'sogo_generate_view', '', 5 );
	add_submenu_page( 'car-models', 'Car completion', "Car completion private", 'read', 'car-completion-private', 'sogo_generate_view' );
	add_submenu_page( 'car-models', 'Car completion', "Car completion commercial", 'read', 'car-completion-commercial', 'sogo_generate_view' );
}

function sogo_generate_view() {
	if ( $_GET['page'] == 'car-models' ) {
		include "templates/meta-car-models-upload.php";
	}

	if ( $_GET['page'] == 'car-completion-private' ) {
		sogo_read_csv( 'PRATI' );
	}

	if ( $_GET['page'] == 'car-completion-commercial' ) {
		sogo_read_csv( 'MISCHARI' );
	}
}

/**
 * Import car models to db
 *
 * @return bool
 * @throws PHPExcel_Exception
 * @throws PHPExcel_Reader_Exception
 */
function sogo_insert_car_models() {

	if ( ! isset( $_POST['sogo_import_models'] ) ) {
		return false;
	}
	/* --- security verification --- */
	if ( ! wp_verify_nonce( $_POST['sogo_import_models'], 'sogo_models' ) ) {
		return false;
	} // end if

	$result = readexcel( $_FILES['sogo_import_car_model']['tmp_name'], isset( $_POST['sogo_truncate_table'] ) ? true : false );

	if ( empty( $result['errors'] ) ) {
		wp_redirect( admin_url( 'admin.php?page=car-models&import=success' ) );
	} else {
		wp_redirect( admin_url( 'admin.php?page=car-models&import=failure' ) );
	}

}

add_action( 'admin_init', 'sogo_insert_car_models' );

/**
 * Read car models excel
 *
 * @param $filename
 * @param bool $override
 *
 * @return array|bool
 * @throws PHPExcel_Exception
 * @throws PHPExcel_Reader_Exception
 */
function readexcel( $filename, $override = false ) {

	/** Include PHPExcel */
	require_once dirname( __FILE__ ) . '/phpexcel/PHPExcel.php';

	$objReader = PHPExcel_IOFactory::createReader( 'Excel2007' );
	if ( $objReader->canRead( $filename ) === false ) {
		return false;
	}
	$objPHPExcel = $objReader->load( $filename );

//  Get worksheet dimensions
	$sheet         = $objPHPExcel->getSheet( 0 );
	$highestRow    = $sheet->getHighestRow();
	$highestColumn = $sheet->getHighestColumn();

	$errors = array();
	global $wpdb;

	$table = $wpdb->prefix . 'car_models';

	if ( $override ) {
		$wpdb->query( "TRUNCATE TABLE `" . $table . "`" );
	}

//  Loop through each row of the worksheet in turn
	for ( $row = 2; $row <= $highestRow; $row ++ ) {
		//  Read a row of data into an array
		$rowData = $sheet->rangeToArray( 'A' . $row . ':' . $highestColumn . $row,
			null,
			true,
			false );
		//  Insert row data array into your database of choice here

		if ( ! is_null( $rowData [0][0] ) ) {
			$data = array(
				'code_levi'    => $rowData [0][0],
				'manufacturer' => $rowData [0][1],
				'model'        => $rowData [0][2],
				'sub_model'    => $rowData [0][3],
				'year'         => $rowData [0][4],
			);

			if ( $wpdb->insert( $table, $data ) !== 1 ) {
				$errors[] = $data + array( 'error' => $wpdb->last_error );
			}

		}
	}

	$arr = array(
		'errors' => $errors
	);

	return $arr;
}


////////

/**
 * remove editor from pages
 */
function hide_editor() {

	// Get the Post ID.
	if ( isset ( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	} else if ( isset ( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}

	if ( ! isset ( $post_id ) || empty ( $post_id ) ) {
		return;
	}

	// Get the name of the Page Template file.
	$template_file = get_post_meta( $post_id, '_wp_page_template', true );
	$arr           = array( 'front-page.php' );

	if ( in_array( $template_file, $arr ) ) { // edit the template name
		remove_post_type_support( 'page', 'editor' );
	}

}

//add_action( 'admin_init', 'hide_editor' );


function sogo_get_next_posts_link( $label = null, $max_page = 0 ) {
	global $paged, $wp_query;

	if ( ! $max_page ) {
		$max_page = $wp_query->max_num_pages;
	}

	if ( ! $paged ) {
		$paged = 1;
	}

	$nextpage = intval( $paged ) + 1;

	if ( null === $label ) {
		$label = __( 'Next Page &raquo;' );
	}

	if ( ! is_single() && ( $nextpage <= $max_page ) ) {
		return next_posts( $max_page, false );
	}

	return false;
}


function sogo_move_comment_field_to_bottom( $fields ) {
	$comment_field = $fields['comment'];
	unset( $fields['comment'] );
	$fields['comment'] = $comment_field;

	return $fields;
}

add_filter( 'comment_form_fields', 'sogo_move_comment_field_to_bottom' );

function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}

add_filter( 'upload_mimes', 'cc_mime_types' );


function my_acf_init() {

	acf_update_setting( 'google_api_key', 'AIzaSyCESsV_VCvI8NtKYA10oJ8Be_cWeb5SZVc' );
}

add_action( 'acf/init', 'my_acf_init' );


function sogo_header_script() {
	sogo_print_script( '_sogo_header_scripts' );
}

add_action( 'wp_head', 'sogo_header_script' );

function sogo_footer_script() {
	sogo_print_script( '_sogo_footer_scripts' );
}

add_action( 'wp_footer', 'sogo_footer_script' );

function sogo_print_script( $key ) {
	if ( function_exists( 'have_rows' ) ) {
		while ( have_rows( $key, 'option' ) ): the_row();
			echo PHP_EOL . "<!--    " . get_sub_field( 'name' ) . "        -->" . PHP_EOL;
			the_sub_field( 'scripts', false );
			echo PHP_EOL . "<!--   END -  " . get_sub_field( 'name' ) . "        -->" . PHP_EOL;
		endwhile;
	}

}

/**
 * social link
 */
function sogo_footer_get_logo_link() {
	?>

    <div class="mb-2">
        <a href="<?php echo get_home_url(); ?>" class="d-inline-block">
            <img src="<?php echo ROOT_PATH . '/images/logo.png'; ?> " alt="logo" class="img-fluid">
        </a>
    </div>

	<?php
}

function sogo_footer_logo_shortcode() {
	ob_start();
	sogo_footer_get_logo_link();

	return ob_get_clean();
}

add_shortcode( 'sogo_footer_logo', 'sogo_footer_logo_shortcode' );


/**
 * social link
 */
function sogo_footer_get_social_links() {
	?>
    <ul class="font-0">
		<?php $margin = ! wp_is_mobile() ? 'ml-2' : 'mx-2'; ?>
		<?php while ( have_rows( '_sogo_footer_social_media', 'option' ) ) : the_row();
			$link = get_sub_field( 'link' );
			$icon = get_sub_field( 'icon' );

			?>
            <li class="d-inline-block <?php echo $margin; ?>">
                <a target="_blank" class="d-block" href="<?php echo $link; ?>"
                   title="<?php echo $text; ?>"
                   aria-label="<?php _e( 'Social', 'sogoc' ) ?>">
                    <i class="<?php echo $icon; ?> icon-x2"></i>
                </a>
            </li>
		<?php endwhile; ?>
    </ul>
	<?php
}

function sogo_footer_social_shortcode() {
	ob_start();
	sogo_footer_get_social_links();

	return ob_get_clean();
}

add_shortcode( 'sogo_footer_social_links', 'sogo_footer_social_shortcode' );


/**
 * sogo phone
 */
function sogo_footer_get_phone() {
	?>
    <a target="_blank" class="d-block mb-2"
       href="tel:<?php echo get_field( '_sogo_footer_phone_text', 'options' ); ?>  " title="phone">
        <i class="<?php echo get_field( '_sogo_footer_phone_icon', 'option' ); ?> icon-x2 align-middle"></i>
        <span class="d-inline-block align-middle text-6 normal"><?php echo get_field( '_sogo_footer_phone_text', 'option' ); ?></span>
    </a>
	<?php
}

function sogo_footer_phone_shortcode() {
	ob_start();
	sogo_footer_get_phone();

	return ob_get_clean();
}

add_shortcode( 'sogo_footer_phone', 'sogo_footer_phone_shortcode' );


/**
 * facebook
 */
function sogo_get_facebook() {
	?>
    <div class="fb-page"
         data-href="<?php echo get_field( '_sogo_footer_facebook_link', 'option' ); ?>"
         data-hide-cover="false"
         data-show-facepile="true"
         data-width="420"></div>
	<?php ; ?>

	<?
}

function sogo_facebook_shortcode() {
	ob_start();
	sogo_get_facebook();

	return ob_get_clean();
}

add_shortcode( 'sogo_facebook', 'sogo_facebook_shortcode' );


//category level
function sogo_get_first_level_cat( $cat ) {
	if ( $cat->parent == 0 ) {
		return $cat;
	} else {
		return sogo_get_first_level_cat( get_term( $cat->parent, $cat->taxonomy ) );
	}
}

function sogo_get_first_level_parent( $post ) {

	if ( $post->post_parent == 0 ) {
		return $post->ID;
	} else {
		return sogo_get_first_level_parent( get_post( $post->post_parent ) );
	}
}


/**
 * sogo change posts per page
 */
function sogo_change_posts_per_page( $query ) {
	if ( is_admin() || ! $query->is_main_query() ) {
		return;
	}

//	if ( is_post_type_archive( 'form' ) || is_post_type_archive( 'message' ) ) {
//		$query->set( 'posts_per_page', 12 );
//	}
//
//	if ( is_post_type_archive( 'menu' ) ) {
//		$query->set( 'posts_per_page', 20 );
//	}

}

add_filter( 'pre_get_posts', 'sogo_change_posts_per_page' );


/**
 * sandbox file_get_content fix
 */
function sogo_file_get_contents( $file ) {
	$username = 'dev';
	$password = 'sogodev';

	$context = stream_context_create(
		array(
			'http' => array(
				'header' => "Authorization: Basic " . base64_encode( "$username:$password" )
			)
		) );

	return file_get_contents( $file, false, $context );
}


/**
 * sogo custom search form
 */
function my_search_form( $form ) {
	$placeholder = __( 'Search', 'sogoc' );

	$form = '<form role="search" method="get" id="searchform-1" class="searchform mb-3" action="' . esc_url( home_url( '/' ) ) . '" >
    <div>
        <label class="screen-reader-text" for="custom-search">' . __( 'Search for:' ) .
	        '</label>
        <input aria-label="Text input for search" type="search" name="custom-search"
         placeholder="' . $placeholder . '"  id="custom-search">
           <button class="widget-search-btn icon-search icon-x1 color-1" type="submit">
               
           </button>
   </div>
    </form>';

	return $form;
}

add_filter( 'get_search_form', 'my_search_form', 100 );


/**
 * sogo paginate
 */
function sogo_paginate() {
	global $wp_query;
	if ( $wp_query->max_num_pages > 1 ): ?>
        <div class="page-navigation text-center">
			<?php
			if ( function_exists( 'wp_pagenavi' ) ):
				wp_pagenavi();
			endif; ?>
        </div>
	<?php endif;
}

/**
 * Take all terms of specific taxonomy
 *
 * @param $tax
 *
 * @return array
 */
function sogo_get_first_object_term_image( $tax, $acf = false ) {
	$terms = get_terms( [
		'taxonomy'   => $tax,
		'hide_empty' => false,
	] );

	if ( $terms ) {
		$taxo_data = array();
		foreach ( $terms as $key => $term ) {
			$taxo_data[ $key ]['name']  = $term->name;
			$taxo_data[ $key ]['image'] = get_field( $acf, $tax . '_' . $term->term_id );
			$taxo_data[ $key ]['link']  = get_term_link( $term );
		}

		return $taxo_data;
	}
}


/**
 * get image from youtube video if no image is provided
 */
function sogo_youtube_filed_thumbnail( $field, $url, $image_size, $post_id ) {
	$image = get_field( $field, $post_id );

	if ( empty( $image ) ) {
		$image = sogo_get_youtube_thmb( get_field( $url, $post_id, false ) );
		$title = "youtube video";
	} else {
		$image = wp_get_attachment_image_url( get_field( '_sogo_section_simple_4_image', $post_id ),
			$image_size );
		$title = get_post_meta( get_field( '_sogo_section_simple_4_image' ), '_wp_attachment_image_alt', true );
	}
	echo sprintf( "<img class='%s' src='%s' alt='%s' title='%s'/>", 'bradius-1 w-100', $image, $title, $title );
}


/**
 *  print input
 */
function sogo_do_input( $wrapper, $field, $label, $type = "text", $class = "", $array_data = false, $help_array = flase ) {

	include "templates/form/input.php";
}

/**
 *  print input
 */
function sogo_do_input_1( $wrapper, $field, $label, $type = "text", $class = "", $array_data = false, $help_array = flase ) {

	include "templates/form/input-1.php";
}

function sogo_do_input_2( $wrapper, $field, $label, $type = "text", $class = "", $auto_data, $help_array = flase ) {

	include "templates/form/input-2.php";
}

/**
 *  print select
 */
function sogo_do_select( $label, $name, $options_array, $db_array = false, $i = 1, $class = '', $ins_order = false, $array_data = false, $help_array = flase ) {
	include 'templates/form/select.php';
}

function sogo_do_select_1( $label, $name, $options_array, $db_array = false, $i = 1, $class = '', $ins_order = false, $array_data = false ) {
	include 'templates/form/select-1.php';
}

function sogo_do_select_filled( $label, $name, $options_array, $class = '', $filled_params ) {
	include 'templates/form/select-filled.php';
}

function sogo_do_select_filled_key( $label, $name, $options_array, $class = '', $filled_params, $start_zero = false ) {
	include 'templates/form/select-filled-key.php';
}

/**
 * print video modal
 */
function sogo_do_video_modal( $video, $acf_image_field = '', $size = '', $class = '' ) {
	include "templates/video-modal.php";
}

function sogo_do_compare_contact_us() {


}

/**
 * thank you page
 */
function mycustom_wp_footer() {
	$thank_you_page_url = get_page_link( 222 );
	?>
    <script type="text/javascript">
        document.addEventListener('wpcf7mailsent', function (event) {
            location = "<?php echo $thank_you_page_url?>";
        }, false);
    </script>
	<?php
}


add_action( 'wp_footer', 'mycustom_wp_footer' );

function sogo_do_continue_btn( $special_class = '' ) {
	include 'templates/form/button-continue.php';
}


// function sogo_set_dates() {
//text-1 color-4
// 	$is_friday   = date( 'w' ) === 5;
// 	$is_saturday = date( 'w' ) === 6;
//
// 	$today = date( 'Y-m-d', strtotime( 'yesterday' ) );
//
// 	$full_days = explode( "\r\n", get_field( '_sogo_full_days', 'option', false ) );
// 	$half_days = explode( "\r\n", get_field( '_sogo_half_days', 'option', false ) );
//
//
// 	$count = $is_saturday ? 1 : 0;
//
// 	// check if current day is vacation || saturday
//
// 	$count = sogo_is_day_in_array_recursive( $today, $full_days, $count );
//
// 	return $count;
// }
//
//
// function sogo_is_day_in_array_recursive( $today, $days, $count ) {
//
// 	$tomorrow    = date( "Y-m-d", strtotime( $today . " +1 days" ) );
// 	$is_saturday = date( "w", strtotime( $tomorrow ) ) == 6;
//
//
// 	if ( in_array( $tomorrow, $days ) || $is_saturday ) {
// 		// found match  - check if next day is day off
// 		$count = sogo_is_day_in_array_recursive( $tomorrow, $days, $count + 1 );
// 	}
//
// 	return $count;
// }

/**
 *
 * cannot select saturday
 * cannot select working day after 16:00
 * cannot select friday after 12:00
 * cannot select vacation day
 * cannot select half day after 12:00
 *
 * @return int
 */
function sogo_set_dates() {
	date_default_timezone_set( get_option( 'timezone_string' ) );
	// $is_friday = date('w') === 5;
	// $is_saturday = date( 'w' ) === 6;

//	$today = date( 'Y-m-d' );

//	$full_days = explode( "\r\n", get_field( '_sogo_full_days', 'option', false ) );
	//$half_days = explode( "\r\n", get_field( '_sogo_half_days', 'option', false ) );
	$date = date( 'Y-m-d' );
	$time = date( 'H:i' );

	// $count = $is_saturday ? 1 : 0;
	$count = sogo_is_half_lday( $date, $time );

	// if we got 1 - it means that it is friday / half day and we pass 12:00
	if ( $count ) {
		$date = date( 'Y-m-d', strtotime( 'tomorrow' ) );
	} else {
		// check if now we are after 16:00
		$time = date( 'H:i' );

		if ( $time > '16:00' ) {
			$count ++;
			$date = date( 'Y-m-d', strtotime( 'tomorrow' ) );
		}
	}

	$temp = true;
	while ( $temp ) {
		$temp = sogo_is_full_day( $date );
		// set the date to tomorrow of the $date
		$date  = date( "Y-m-d", strtotime( $date . " +1 days" ) );
		$count += $temp;
	}

	//check if current day is vacation || saturday
	//$count = sogo_is_day_in_array_recursive( $today, $full_days, $half_days, $count );

	return $count;
}


/**
 * @return int
 *  as we talk about half day - it is always today!
 */
function sogo_is_half_lday( $date, $time ) {
	date_default_timezone_set( get_option( 'timezone_string' ) );
	$half_days = explode( "\r\n", get_field( '_sogo_half_days', 'option', false ) );

	if ( ( in_array( $date, $half_days ) || date( "w", strtotime( $date ) ) == 5 ) ) {
		//check if its after 12 pm on a friday
//		$time = date( 'H:i' );

		if ( $time > '12:00' ) {
			return 1;
		}
	}

	return 0;


}

/**
 * @param string $date - format Y-m-d
 *
 * @return int
 * need to check also the next days.
 */
function sogo_is_full_day( $date ) {

	date_default_timezone_set( get_option( 'timezone_string' ) );
	$full_days   = explode( "\r\n", get_field( '_sogo_full_days', 'option', false ) );
	$is_saturday = date( "w", strtotime( $date ) ) == 6;
	if ( $is_saturday || in_array( $date, $full_days ) ) {
		return 1;
	}

	return 0;


}


function sogo_is_day_in_array_recursive( $today, $days, $half_days, $count, $show_tomorrow = false ) {

	date_default_timezone_set( get_option( 'timezone_string' ) );
}


function sogo_get_cookie_param( $name ) {

	$params = isset( $_COOKIE['sogo-form-1'] ) ? stripslashes( $_COOKIE['sogo-form-1'] ) : false;

	$params = json_decode( $params, true );


	return isset( $params[ $name ] ) ? $params[ $name ] : '';
}


function sogo_form_1_submit() {

	$form_1 = [];
	$form_1 = isset( $_POST['form_1'] ) ? $_POST['form_1'] : false;

	if ( $form_1 ) {
		parse_str( $_POST['form_1'], $form_1 );
	}

	debug( $form_1 );

	die();
}

add_action( 'wp_ajax_sogo_form_1_submit', 'sogo_form_1_submit' );
add_action( 'wp_ajax_nopriv_sogo_form_1_submit', 'sogo_form_1_submit' );


function sogo_get_car_details_from_go() {
	$license_number = trim( strip_tags( $_POST['license_number'] ) );
	$go             = null;
	if ( (int) $license_number === intval( $license_number ) ) {
		include dirname( __FILE__ ) . '/insurance-api/go/lib/gows.php';
		$go     = new GoWs( [] );
		$result = $go->calc_price( $_POST );

		if ( ! empty( $result ) && ! empty( $result['car_details'] ) ) {
			wp_send_json_success( [ 'message' => 'success', 'data' => $result ] );
		} else {
			wp_send_json_success( [ 'message' => 'empty', 'data' => [] ] );
		}
		exit();
	}

	if ( is_null( $go ) ) {
		wp_send_json_success( [ 'message' => 'error', 'data' => 'empty' ] );
		exit();
	}

	return false;
}

add_action( 'wp_ajax_sogo_get_car_details_from_go', 'sogo_get_car_details_from_go' );
add_action( 'wp_ajax_nopriv_sogo_get_car_details_from_go', 'sogo_get_car_details_from_go' );

function sogo_if_checked_from_cookie( $field, $value ) {

	// get cookie array
	$params = isset( $_COOKIE['sogo-form-1'] ) ? stripslashes( $_COOKIE['sogo-form-1'] ) : false;

	$params = (array) json_decode( $params );

	//check which value is selected
	if ( $params[ $field ] == $value ) {
		//check the selected value
		return 'checked';
	}

	return '';
}

function sogo_set_params_for_mondatory_insurance( $data ) {
	$params_temp = array(
		'hdnForCaptcha'           => '',
		// always empty
		'code_owner'              => '1001',
		// always
		'insurance_date'          => $data['insurance_period'],
		//'01/05/2018',
		'parameters[0].parameter' => 'D',
		'parameters[0].value'     => $data['gender'],
		//'1',  // gender ////1: private, 2: motorcycle, 3: bus , 4: taxi, 5: van, 7: special
		'parameters[1].parameter' => 'D2',
		'parameters[1].value'     => $data['youngest-driver'],
		//'34', // age
		'parameters[2].parameter' => 'E',
		'parameters[2].value'     => $data['lowest-seniority'],
		//'0',
		'parameters[3].parameter' => 'F',
		'parameters[3].value'     => (string) ( (int) $data['law-suites-3-year'] + (int) $data['body-claims'] ),
		//'0', // number of accident
		'parameters[4].parameter' => 'G',
		'parameters[4].value'     => $data['license-suspensions'],
		//'0', // number of psilot
		'parameters[8].parameter' => 'J',
		'parameters[8].value'     => $data['abs'] == '1' ? '1' : '2',
		'parameters[9].parameter' => 'K',
		'parameters[9].value'     => $data['esp'] == '1' ? '1' : '2'
	);


	//verify if vehicle type is private
	if ( $data['vehicle-type'] == '1' ) {
		$params_temp['sheet_id']                 = '1';
		$params_temp['parameters[5].parameter']  = 'N';
		$params_temp['parameters[5].value']      = '1';
		$params_temp['parameters[6].parameter']  = 'A';
		$params_temp['parameters[6].value']      = $data['engine_capacity']; //'1800', // engine capacity
		$params_temp['parameters[7].parameter']  = 'O';
		$params_temp['parameters[7].value']      = '100';
		$params_temp['parameters[10].parameter'] = 'H';
		$params_temp['parameters[10].value']     = '4';
		$params_temp['parameters[11].parameter'] = 'L';
		$params_temp['parameters[11].value']     = $data['fcw'] == '1' ? '1' : '2';
		$params_temp['parameters[12].parameter'] = 'M';
		$params_temp['parameters[12].value']     = $data['ldw'] == '1' ? '1' : '2';
		$params_temp['parameters[13].parameter'] = 'B';
		$params_temp['parameters[13].value']     = '6';
	} else {
		$params_temp['sheet_id']                 = '5';
		$params_temp['parameters[5].parameter']  = 'A';
		$params_temp['parameters[5].value']      = '0';
		$params_temp['parameters[6].parameter']  = 'N';
		$params_temp['parameters[6].value']      = '1';
		$params_temp['parameters[7].parameter']  = 'B';
		$params_temp['parameters[7].value']      = '9';
		$params_temp['parameters[10].parameter'] = 'L';
		$params_temp['parameters[10].value']     = $data['fcw'] == '1' ? '1' : '2';
		$params_temp['parameters[11].parameter'] = 'M';
		$params_temp['parameters[11].value']     = $data['ldw'] == '1' ? '1' : '2';
		$params_temp['parameters[12].parameter'] = 'H';
		$params_temp['parameters[12].value']     = '4';
	}

	return $params_temp;
}

function sogo_check_lowest_price( $needle, $haystack ) {
	$total_needle = $needle['comprehensive'] + $needle['mandatory'];

	foreach ( $haystack as $key => $price ) {
		$total_haystack[] = $price['comprehensive'] + $price['mandatory'];
	}

	if ( $total_needle > min( $total_haystack ) ) {

		return true;
	}

	return false;
}


function sogo_mix_by_lowest_price($array,  $array2 ) {

	if ( empty( $array ) || empty( $array2 ) ) {
		$array = array();

		return $array;
	}

	foreach ( $array as $key => &$val ) {

		if ( $val['company'] !== $array2['company'] ) {
			$val['company']              = $array2['company'] . ' + ' . $val['company'];
			$val['mandatory_company_id'] = $array2['company_id'];
			if ( isset( $array2['mandat_price'] ) && ! empty( $array2['mandat_price'] ) && $array2['mandat_price'] > 0 ) {
				$val['mandatory'] = $array2['mandat_price'];
			} else {
				$val['mandatory'] = $array2['price'];
			}
		}
	}

	return $array;

}

function sogo_sort_by_total_price( $array , $mekif) {

	if ( empty( $array ) ) {
		$array = array();

		return $array;
	}

	if($mekif){
		usort( $array, function ( $item1, $item2 ) {
			if ( (int) $item1['mandatory'] + (int) $item1['comprehensive'] == (int) $item2['mandatory'] + (int) $item2['comprehensive'] ) {
				return 0;
			}

			return (int) $item1['mandatory'] + (int) $item1['comprehensive'] < (int) $item2['mandatory'] + (int) $item2['comprehensive'] ? - 1 : 1;
		} );
    }else{
		usort( $array, function ( $item1, $item2 ) {
			if ( (int) $item1['mandat_price']  == (int) $item2['mandat_price']   ) {
				return 0;
			}

			return (int) $item1['mandat_price']   < (int) $item2['mandat_price']   ? - 1 : 1;
		} );
    }


	return $array;
}

/**
 *
 * @param $file_prefix
 *
 * @return bool
 */
function sogo_read_csv( $file_prefix ) {

	if ( ! $file_prefix ) {
		return false;
	}

	$file_path = get_stylesheet_directory() . '/insurance-api/otzar/DGAMIM-';

	if ( $file_prefix == 'PRATI' ) {
		$filename = $file_path . $file_prefix . '.csv';

		if ( ! file_exists( $filename ) ) {
			return false;
		}

//		sogo_update_car_models_from_dep_trans( $filename, 10, 24, 33, 32 );
//		sogo_update_car_esp_from_dep_trans();
		sogo_upload_prati_mishari_csv_to_db( $filename, 10, 24, 33, 32, 1 );
	}

	if ( $file_prefix == 'MISCHARI' ) {
		$filename = $file_path . $file_prefix . '.csv';

		if ( ! file_exists( $filename ) ) {
			return false;
		}

//		sogo_update_car_models_from_dep_trans( $filename, 12, 26, 35, 34 );
//		sogo_update_car_esp_from_dep_trans();
		sogo_upload_prati_mishari_csv_to_db( $filename, 12, 26, 35, 34, 2 );
	}
}

function sogo_upload_prati_mishari_csv_to_db( $filename, $abs_index, $esp_index, $fcw_index, $ldw_index, $type ) {
	global $wpdb;

	//prepare csv array
	$file = fopen( $filename, "r" );
	while ( ( $getData = fgetcsv( $file, 0, ";" ) ) !== false ) {
//		$final_report[] = $getData;

		$data = array(
			'manufacturer_number' => $getData[1],
			'license_code'        => $getData[3],
			'abs'                 => trim( $getData[ $abs_index ] ) == 'X' ? 1 : 0,
			'esp'                 => trim( $getData[ $esp_index ] ) == 'X' ? 1 : 0,
			'fcw'                 => trim( $getData[ $fcw_index ] ) == 'X' ? 1 : 0,
			'ldw'                 => trim( $getData[ $ldw_index ] ) == 'X' ? 1 : 0,
			'type'                => $type,
		);

		$wpdb->insert( 'wp_otzar', $data );
	}
	fclose( $file );

}

function sogo_update_car_esp_from_dep_trans() {

	global $wpdb;

	$otzar_table = $wpdb->prefix . 'otzar';

	$query = "SELECT code_levi, year, id FROM wp_car_models WHERE esp IS NULL";

	$car_models = $wpdb->get_results( $query, ARRAY_A );

	foreach ( $car_models as $key => $car ) {

		//get rows of cars with specific code levi and year to check them in dep trans db, (wp_otzar)
		$snapir_query  = "SELECT license_code, manufacturer_number FROM wp_snapir WHERE car_year = '{$car['year']}' AND code_levi = '{$car['code_levi']}'";
		$snapir_models = $wpdb->get_results( $snapir_query, ARRAY_A );

		if ( empty( $snapir_models ) ) {
			//continue to next car, probably we dont have this car with this year in db
			continue;
		} else {
			//check how much cars we found
			$cars_count = count( $snapir_models );
			$temp_model = '';//temp var to compare in the end if we have one car different from other

			//continue to next car
			$continue = false;

			//run throw snapir model with same code levi
			foreach ( $snapir_models as $k => $model ) {

				//must be int
				$manufacturer_number = absint( $model['manufacturer_number'] );
				$license_code        = absint( $model['license_code'] );

				$otzar_query = "SELECT esp FROM {$otzar_table} WHERE manufacturer_number = {$manufacturer_number} AND license_code = {$license_code}";

				$model_esp = $wpdb->get_var( $otzar_query );

				//verify first model
				if ( $k == 0 ) {

					//if null (no results in otzar) go to next model from snapir
					if ( is_null( $model_esp ) ) {
						//verify if we have only one model in snapir, go to next
						if ( ( $k + 1 ) == $cars_count ) {
							break;
						} else {
							continue;
						}
					} else {

						//verify if we have only one model in snapir
						if ( ( $k + 1 ) == $cars_count ) {
							$temp_model = $model_esp;
//		                    $continue = true;

							break;
						} else {
							$temp_model = $model_esp;
							continue;
						}
					}
				}

				//verify if model exists in otzar
				if ( is_null( $model_esp ) ) {
					continue;
				} else {

					//verify if even one model from otzar different, update car model with '2' param
					if ( $model_esp != $temp_model ) {
						//verify if temp not empty, other it will be allways different from model
						if ( $temp_model != '' ) {
							//we cant continue, we saw already change
							$continue = true;
							break;
						} else {
							continue;
						}
					}
				}
			}

			//verify if we need to do update
			if ( $continue ) {
				//verify if we have data to update
				if ( $temp_model != '' ) {
					$car_data = array(
						'esp' => 2//update with 2 when it was 1 different esp value from others in snapir
					);

					$car_where_data = array(
						'id' => $car['id']
					);

					$wpdb->update( 'wp_car_models', $car_data, $car_where_data );
				}
			} else {
				//verify if we have data to update
				if ( $temp_model != '' ) {
					$car_data = array(
						'esp' => $temp_model
					);

					$car_where_data = array(
						'id' => $car['id']
					);

					$wpdb->update( 'wp_car_models', $car_data, $car_where_data );
					continue;
				}
			}
		}
	}
}

/**
 * Update in db at car models with engine capacity, abs, esp, fcw, dw
 *
 * @param $filename
 * @param $abs_index
 * @param $esp_index
 * @param $fcw_index
 * @param $ldw_index
 */
function sogo_update_car_models_from_dep_trans( $filename, $abs_index, $esp_index, $fcw_index, $ldw_index ) {
	//prepare csv array
	$file = fopen( $filename, "r" );
	while ( ( $getData = fgetcsv( $file, 0, ";" ) ) !== false ) {
		$final_report[] = $getData;
	}
	fclose( $file );

	global $wpdb;

	$query = "SELECT license_code, code_levi, year FROM wp_car_models WHERE engine_capacity = '' OR abs IS NULL OR esp IS NULL OR fcw IS NULL OR ldw IS NULL";

	$car_models = $wpdb->get_results( $query, ARRAY_A );

	foreach ( $car_models as $key => $car ) {
		//for check
		/*if($car['license_code'] != '0588-00011'){
			continue;
		}*/

		$codes = explode( '-', $car['license_code'] );

		$product_symbol = absint( $codes[0] );
		$model_code     = absint( $codes[1] );

		//for check
		/*$snapir_query = "SELECT license_code, manufacturer_number FROM wp_snapir WHERE code_levi = '{$car['code_levi']}' AND car_year = '{$car['year']}'";

		$snapir_models = $wpdb->get_results( $snapir_query, ARRAY_A );*/

		foreach ( $final_report as $report ) {

			if ( absint( $report[1] ) == $product_symbol && absint( $report[3] ) == $model_code ) {
				$data = array(
					'engine_capacity' => trim( absint( $report[6] ) ),
					'abs'             => trim( $report[ $abs_index ] ) == 'X' ? true : false,
					'esp'             => trim( $report[ $esp_index ] ) == 'X' ? true : false,
					'fcw'             => trim( $report[ $fcw_index ] ) == 'X' ? true : false,
					'ldw'             => trim( $report[ $ldw_index ] ) == 'X' ? true : false,
				);

				$where_data = array(
					'license_code' => $car['license_code']
				);

				$wpdb->update( 'wp_car_models', $data, $where_data );
			}
		}
	}
}

function sogo_check_vehicle_defense_system() {
	global $wpdb;

	$query = "SELECT * FROM wp_car_models";

	$cars = $wpdb->get_results( $query, ARRAY_A );

	foreach ( $cars as $key => $car ) {

		$snapir_query = "SELECT id, car_model FROM wp_snapir WHERE code_levi = '{$car['code_levi']}' AND car_year = '{$car['year']}'";

		//get cars from snapir by code levi and year
		$snapir_cars = $wpdb->get_results( $snapir_query, ARRAY_A );

		$temp_model = '';

		$answer = true;

		$cars_count = count( $snapir_cars );

		foreach ( $snapir_cars as $k => $snapir_sub ) {

			//check if we in first iteration
			if ( $k == 0 ) {
				//check if we have only one element in array, so we don`t need to iterate
				if ( ( $k + 1 ) == $cars_count ) {
					$answer = true;
					break;
				} else {
					//store first car model in temp that we can check it value in next iteration and continue to next iteration.
					$temp_model = $snapir_sub['car_model'];
					continue;
				}
			}

			//verify if we have al least one model different from another, we stop iteration and reset in car models db to 0.
			if ( $snapir_sub['car_model'] != $temp_model ) {
				$answer = false;
				break;
			}
		}

		//if we have difference, we resetting params in car models db
		if ( ! $answer ) {
			$update_data = array(
				'abs' => 0,
				'esp' => 0,
				'fcw' => 0,
				'ldw' => 0,
			);

			$where_data = array(
				'id' => $car['id']
			);

			$wpdb->update( 'wp_car_models', $update_data, $where_data );
		}


	}
}

function is_equal_sub_models( $arr ) {
	if ( count( array_unique( $arr ) ) <= 1 ) {
		// there's at least one dupe
	}
}

function sogo_check_company_from_db( $insurance_company, $ins_period, $percent, $vehicle_year ) {

//	echo '<pre style="direction: ltr;">';
//	var_dump($insurance_company);
//	echo '</pre>';


	//$zad_g = sogo_get_zad_g( $insurance_company['company_id'], $ins_period, $vehicle_year );//from DB
	//EXISTS IN SogoInsurance class
	$zad_g = sogo_get_zad_g( $insurance_company, $ins_period, $vehicle_year );//from DB //


	$status = false;

	if ( empty( $zad_g ) ) {
		return $status;
	}

	foreach ( $zad_g as $insurance_zad ) {

		//verify if no prices in zad g from db
		if ( empty( $insurance_zad['priceBitul'] ) && empty( $insurance_zad['priceNormal'] ) ) {
			$status = false;
			break;
		}

		if ( $insurance_zad['priceBitul'] > 0 ) {
			// use price normal when it is ok for others.
			$insurance['comprehensive'] = number_format( ( $insurance_zad['priceBitul'] * $percent ) + $insurance_zad['havila'], 2 );
		} else {
			$insurance['comprehensive'] = number_format( ( $insurance_zad['priceNormal'] * $percent ) + $insurance_zad['havila'], 2 );
		}

		$insurance['gvul']        = $insurance_zad['gvul'];
		$insurance['axes']        = $insurance_zad['axes'];
		$insurance['hagana']      = $insurance_zad['hagana'];
		$insurance['grira ']      = $insurance_zad['grira'];
		$insurance['shmashot']    = $insurance_zad['shmashot'];
		$insurance['radio']       = $insurance_zad['radio'];
		$insurance['hearotKlali'] = $insurance_zad['hearotKlali'];
		$insurance['compHavila']  = $insurance_zad['compHavila'];
	}

	//@TODO: don`t know what for it was here
	/*if ( ! $status ) {
		return false;
	}*/

	//$insurance_company - is company info array

	$insurance_company['mf_company_name'] = $insurance_company['company_id'];
	$temp_mandatory_array                 = sogo_insurance_mandatory_request_zad_g( $insurance_company['mf_company_name'], $insurance_company['company_id'] );
//var_dump($insurance_company);
//var_dump($temp_mandatory_array);
	if ( empty( $temp_mandatory_array ) ) {
		return false;
	}

	foreach ( $temp_mandatory_array as $insurance_mandat ) {
		//verify if there is a * in otzar price, if exist its 0 price
		$star_validate = strpos( $insurance_mandat['price'], '*' );
		if ( $star_validate !== false ) {
			continue;
		}

		$insurance['mandatory'] = intval( preg_replace( '/[^\d.]/', '', $insurance_mandat['price'] ) );
	}

	$insurance['protect']    = '';
	$insurance['protect_id'] = '';
	$insurance['id']         = $insurance_company['company_id'];
	$insurance['company']    = $insurance_company['mf_company_name'];
	$insurance['company_id'] = $insurance_company['company_id'];

	return $insurance;
//	array_push( $total_array, $insurance );
}

/**
 *
 * @todo: remove if not needed.
 * Request to insurance API
 *
 * @param array $data
 *
 * @return mixed
 */
function sogo_insurance_api_requests_depreacted( $data, $ins_type, $company_settings ) {
	$code_levi         = sogo_get_levi_code();
	$data['levi-code'] = $code_levi;

	$insurance_before = $data['insurance-before'];

	// total array **************
//	$total_array = array();

	//verify if was insurance before
	if ( $insurance_before == '1' ) {
		$youngest_driver  = $data['youngest-driver'];
		$lowest_seniority = $data['lowest-seniority'];
		$insurance_1_year = $data['insurance-1-year'];
		$insurance_2_year = $data['insurance-2-year'];
		$insurance_3_year = $data['insurance-3-year'];
		$law_suites       = $data['law-suites-3-year'];
	}


	if ( $ins_type == 'MAKIF' ) {
		$total_array = sogo_check_to_use_api( $company_settings, 'MAKIF', $data, $youngest_driver, $lowest_seniority, $law_suites, $insurance_1_year, $insurance_2_year, $insurance_3_year );

	}

	if ( $ins_type == 'ZAD_G' ) {
		$total_array = sogo_check_to_use_api( $company_settings, 'ZAD_G', $data, $youngest_driver, $lowest_seniority, $law_suites, $insurance_1_year, $insurance_2_year, $insurance_3_year );
	}

	return $total_array;
	// sort total array from cheap to expensive
//	return sogo_sort_by_total_price( $total_array );
}

/**
 * Verify if use company api and which
 *
 * @param $insurance_type
 * @param $settings
 * @param $data
 * @param $youngest_driver
 * @param $lowest_seniority
 * @param $law_suites
 * @param $insurance_1_year
 * @param $insurance_2_year
 * @param $insurance_3_year
 *
 * @return array
 */
function sogo_check_to_use_api( $settings, $type, $data, $youngest_driver, $lowest_seniority, $law_suites, $insurance_1_year, $insurance_2_year, $insurance_3_year ) {
	$total_array = array();

//	foreach ( $settings as $key => $comp ) {
//		if ( $comp[$insurance_type] ) {

	switch ( $settings['company_id'] ) {
		case '4':
			// ayalon *******************
			$ayalon     = new Ayalonws( $settings );
			$ayalon_res = $ayalon->calc_price( $data );
echo "1111111111111111111111111";
			//verify if now low suites and check discount
		//	if ( isset( $law_suites ) && $law_suites == '0' ) {
				$disc_price_temp             = sogo_verify_discount( $ayalon_res, $settings, $youngest_driver, $lowest_seniority, $law_suites, $insurance_1_year, $insurance_2_year, $insurance_3_year );
				$ayalon_res['comprehensive'] = $disc_price_temp == false ? $ayalon_res['comprehensive'] : $disc_price_temp;
		//	}

			return $ayalon_res;
//					array_push( $total_array, $ayalon_res );
			break;
		case '8':
			// shirbit *******************
			$shirbit = new shirbitws( $settings );

			$shirbit_res = $shirbit->calc_price( $data );

			//verify if now low suites and check discount
			//if ( isset( $law_suites ) && $law_suites == '0' ) {
				$disc_price_temp              = sogo_verify_discount( $shirbit_res, $settings, $youngest_driver, $lowest_seniority, $law_suites, $insurance_1_year, $insurance_2_year, $insurance_3_year );
				$shirbit_res['comprehensive'] = $disc_price_temp == false ? $shirbit_res['comprehensive'] : $disc_price_temp;
		//	}

			return $shirbit_res;
//					array_push( $total_array, $shirbit_res );
			break;
		case '1':

			// hachshara ***************************************
			$hachshara = new hachsharaws( $settings, $type );

			$hachshara_res = $hachshara->calc_price( $data );
//			echo '<pre style="direction: ltr;">';
//			var_dump($hachshara_res);
//			echo '</pre>';

			//verify if now low suites and check discount
		//	if ( isset( $law_suites ) && $law_suites == '0' ) {
				$disc_price_temp                = sogo_verify_discount( $hachshara_res, $settings, $youngest_driver, $lowest_seniority, $law_suites, $insurance_1_year, $insurance_2_year, $insurance_3_year );
				$hachshara_res['comprehensive'] = $disc_price_temp == false ? $hachshara_res['comprehensive'] : $disc_price_temp;
		//	}

			return $hachshara_res;
//					array_push( $total_array, $hachshara_res);
			/*array_push( $total_array, $hachshara_res[1] );
			array_push( $total_array, $hachshara_res[2] );*/
			break;
	}
//		}
//	}

	return $total_array;
}


/**
 * Mandatory request for zad g
 *
 * @param $company_name
 * @param $company_id
 *
 * @return array|string
 */
function sogo_insurance_mandatory_request_zad_g( $company_name, $company_id ) {
//var_dump($company_name);
	$mandatory_insurance_data = sogo_get_data_for_mandatory_insurance();

	$code_levi = sogo_get_levi_code();

	//remove all leading zeros from levi code
	$code_levi = ltrim( $code_levi, '0' );

	//if code levi length is 7 its commercial vehicle type, else its private
	$vehicle_type_by_levi = strlen( $code_levi );

	$_POST['engine_capacity'] = $mandatory_insurance_data[0]['engine_capacity'];
	$_POST['abs']             = $mandatory_insurance_data[0]['abs'];
	$_POST['esp']             = isset( $_POST['stability-system'] ) ? $_POST['stability-system'] : $mandatory_insurance_data[0]['esp'];
	$_POST['fcw']             = $mandatory_insurance_data[0]['fcw'];
	$_POST['ldw']             = $mandatory_insurance_data[0]['ldw'];
	$_POST['air_bags']        = $mandatory_insurance_data[0]['air_bags'];
	$_POST['vehicle-type']    = $vehicle_type_by_levi != 7 ? '1' : '5';

	$params = sogo_set_params_for_mondatory_insurance( $_POST );

	$ozar   = new ozar_hova( $params, $vehicle_type_by_levi != 7 ? '1' : '5' );
	$prices = $ozar->connect( $params );

	//verify if api is not working
	if ( ! is_array( $prices ) || empty( $prices ) ) {
		$prices = array();

		$result = sogo_get_mandatory_insurance( $company_id );

		$time_zone = new DateTimeZone( 'Asia/Jerusalem' );

		$ins_period      = DateTime::createFromFormat( 'd/m/Y', $_POST['insurance_period'], $time_zone ); //insurance expiring
		$ins_date_finish = DateTime::createFromFormat( 'd/m/Y', $_POST['insurance-date-finish'], $time_zone ); //insurance future expiring

		$dayPast = $ins_date_finish->diff( $ins_period )->format( "%a" );
		$dayPast = (int) $dayPast + 1;
		foreach ( $result as $key => $price ) {

			//which price to use depends on ownership
			if ( $_POST['ownership'] == '1' ) {
				$price_day = $price['privatePrice'] / 365;
			} else {
				$price_day = $price['companyPrice'] / 365;
			}

			$new_price = $price_day * $dayPast;

			//verify discount for ldw - deviation system
			if ( $_POST['deviation-system'] == '1' ) {

				if ( ! empty( $price['ldwDiscount'] ) ) {
					$discount_percent = (int) ceil( ( (int) $price['ldwDiscount'] / 100 ) * $new_price );
					$new_price        = $new_price - (int) $discount_percent;
				}
			}

			//verify discount for lcw - keep distance system
			if ( $_POST['keeping-distance-system'] == '1' ) {

				if ( ! empty( $price['lcwDiscount'] ) ) {
					$discount_percent = (int) ceil( ( (int) $price['lcwDiscount'] / 100 ) * $new_price );
					$new_price        = $new_price - (int) $discount_percent;
				}
			}

//            $company = sogo_get_company_name( $price['companyId'] );

			$prices[ $key ]['price']      = $new_price;
			$prices[ $key ]['company']    = $company_name;
			$prices[ $key ]['company_id'] = (int) $price['companyId'];
		}

		return $prices;
	} else {

		$new_prices = array();

		foreach ( $prices as $price ) {

			if ( empty( $price['company'] ) ) {
				continue;
			}

			//if * in price, we dont need this insurance
			$star_validate = strpos( $price['price'], '*' );
			if ( $star_validate !== false ) {
				continue;
			}

			if ( $company_name == $price['company'] ) {
				array_push( $new_prices, $price );
			}
		}

		return $new_prices;
	}
}

/**
 * Request to mandatory insurance API
 *
 * @return array
 */
function sogo_insurance_mandatory_request( $companies_settings ) {

	$mandatory_insurance_data = sogo_get_data_for_mandatory_insurance();

	$code_levi = sogo_get_levi_code();

	//remove all leading zeros from levi code
	$code_levi = ltrim( $code_levi, '0' );

	//if code levi length is 7 its commercial vehicle type, else its private
	$vehicle_type_by_levi = strlen( $code_levi );

	$_POST['engine_capacity'] = $mandatory_insurance_data[0]['engine_capacity'];
	$_POST['abs']             = $mandatory_insurance_data[0]['abs'];
	$_POST['esp']             = isset( $_POST['stability-system'] ) ? $_POST['stability-system'] : $mandatory_insurance_data[0]['esp'];
	$_POST['fcw']             = $mandatory_insurance_data[0]['fcw'];
	$_POST['ldw']             = $mandatory_insurance_data[0]['ldw'];
	$_POST['air_bags']        = $mandatory_insurance_data[0]['air_bags'];
	$_POST['vehicle-type']    = $vehicle_type_by_levi != 7 ? '1' : '5';


	$params = sogo_set_params_for_mondatory_insurance( $_POST );


	$ozar   = new ozar_hova( $params, $vehicle_type_by_levi != 7 ? '1' : '5' );
	$prices = $ozar->connect( $params );

//	$prices = '';

	//verify if api is not working
	if ( ! is_array( $prices ) || empty( $prices ) ) {
		$prices = array();

		$result = sogo_get_mandatory_insurance();

		$time_zone = new DateTimeZone( 'Asia/Jerusalem' );

		$ins_period      = DateTime::createFromFormat( 'd/m/Y', $_POST['insurance_period'], $time_zone ); //insurance expiring
		$ins_date_finish = DateTime::createFromFormat( 'd/m/Y', $_POST['insurance-date-finish'], $time_zone ); //insurance future expiring

		$dayPast = $ins_date_finish->diff( $ins_period )->format( "%a" );

		$dayPast = (int) $dayPast - 1;
		foreach ( $result as $key => $price ) {

			if ( sogo_get_company_is_on( $price['companyId'], 'use_hova', $companies_settings ) ) {

				//which price to use depends on ownership
				if ( $_POST['ownership'] == '1' ) {
					$price_day = $price['privatePrice'] / 365;
				} else {
					$price_day = $price['companyPrice'] / 365;
				}

				$new_price = $price_day * $dayPast;

				//verify discount for ldw - deviation system
				if ( $_POST['deviation-system'] == '1' ) {

					if ( ! empty( $price['ldwDiscount'] ) ) {
						$discount_percent = (int) ceil( ( (int) $price['ldwDiscount'] / 100 ) * $new_price );
						$new_price        = $new_price - (int) $discount_percent;
					}
				}

				//verify discount for lcw - keep distance system
				if ( $_POST['keeping-distance-system'] == '1' ) {

					if ( ! empty( $price['lcwDiscount'] ) ) {
						$discount_percent = (int) ceil( ( (int) $price['lcwDiscount'] / 100 ) * $new_price );
						$new_price        = $new_price - (int) $discount_percent;
					}
				}

				$company = sogo_get_company_name( $price['companyId'] );

				$prices[ $key ]['price']      = $new_price;
				$prices[ $key ]['company']    = $company;
				$prices[ $key ]['company_id'] = (int) $price['companyId'];
			}
		}

		return $prices;
	} else {

		$new_prices = array();

		foreach ( $prices as $price ) {

			if ( empty( $price['company'] ) ) {
				continue;
			}

			//if * in price, we dont need this insurance
			$star_validate = strpos( $price['price'], '*' );
			if ( $star_validate !== false ) {
				continue;
			}


			foreach ( $companies_settings as $key => $comp ) {
				//verify if you are not in makif or zad g
//				if ( ! isset( $_GET['insurance-type'] ) ) {

				//verify if same company in back end
				if ( $comp['mf_company_name'] == $price['company'] ) {

					if ( $comp['use_hova'] ) {
						array_push( $new_prices, $price );
					}
				}
//				}
			}
		}

		return $new_prices;
	}
}

/**
 * Verify if company is on in back end to work with
 *
 * @param $company_id
 * @param $type
 * @param $companies_settings
 *
 * @return bool
 */
function sogo_get_company_is_on( $company_id, $type, $companies_settings ) {
	$company_id = absint( $company_id );


	if ( isset( $companies_settings[ $company_id ] ) ) {
		if ( $companies_settings[ $company_id ][ $type ] ) {
			return true;
		}

	}

	return false;
}

/**
 * Get company name
 *
 * @param $company_id
 *
 * @return mixed
 */
function sogo_get_company_name( $company_id ) {
	$comp_repeater = get_field( '_sogo_insurance_companies', 'option' );

	foreach ( $comp_repeater as $comp ) {


		if ( $company_id == $comp['company_id'] ) {
			//	echo $comp['crm_company_name'] .'\n\r';
			return $comp['crm_company_name'];
		}
	}
}

/**
 * Get mandatory num of payments
 *
 * @param $company
 *
 * @return mixed
 */
function sogo_get_mandatory_company_payments( $company ) {

	$comp_repeater = get_field( '_sogo_insurance_companies', 'option' );
	//echo '<pre style="direction: ltr;">';
	//var_dump($comp_repeater);
	//echo '</pre>';
	foreach ( $comp_repeater as $comp ) {
//		echo '<pre style="direction: ltr;">';
//		var_dump($comp);
//		echo '</pre>';

		if ( $company == $comp['crm_company_name'] ) {
			return $comp['mandatory_num_payments'];
		}
	}

}

/**
 * Get comprehensive num of payments
 *
 * @param $company
 *
 * @return mixed
 */
function sogo_get_comprehensive_company_payments( $company ) {

	$comp_repeater = get_field( '_sogo_insurance_companies', 'option' );

	foreach ( $comp_repeater as $comp ) {
		if ( $company == $comp['mf_company_name'] ) {
			return $comp['other_num_payments'];
		}
	}

}

/**
 * Get price for mandatory insurance only
 *
 * @return array|null|object
 */
function sogo_get_mandatory_insurance( $comp_id = false ) {
	global $wpdb;

	$esp   = $_POST['esp'] == 0 ? 1 : 2;//if no, set 1 else set 2 if exists
	$karit = empty( $_POST['air_bags'] ) ? '0' : $_POST['air_bags'];


	$time_zone  = new DateTimeZone( 'Asia/Jerusalem' );
	$ins_period = DateTime::createFromFormat( 'd/m/Y', $_POST['insurance_period'], $time_zone );
	$ins_period->setTime( 9, 00 );//set time of date to morning

	$day   = $ins_period->format( 'j' );
	$month = $ins_period->format( 'n' );
	$year  = $ins_period->format( 'Y' );

	$code_levi = sogo_get_levi_code();

	$table = $wpdb->prefix . 'hova_ins';

	//remove all leading zeros from levi code
	$code_levi = ltrim( $code_levi, '0' );

	//if code levi length is 7 its commercial vehicle type, else its private
	$vehicle_type_by_levi = strlen( $code_levi );

	$vehicle_type_by_levi = $vehicle_type_by_levi != 7 ? 1 : 2;

	$query = "SELECT * FROM {$table} ";

	if ( $comp_id ) {
		$query .= "WHERE companyId = {$comp_id} and carType = {$vehicle_type_by_levi} ";
	} else {
		$query .= "WHERE carType = {$vehicle_type_by_levi} ";
	}

	$query .= "and (ageStart <= {$_POST['youngest-driver']}) 
              and (ageEnd >= {$_POST['youngest-driver']}) 
              and (engineStart <= {$_POST['youngest-driver']}) 
              and (engineEnd >= {$_POST['youngest-driver']}) 
              and (vetekStart <= {$_POST['lowest-seniority']}) 
              and (vetekEnd >= {$_POST['lowest-seniority']}) 
              and (karit <= {$karit}) 
              and (karitEnd >= {$karit}) 
              and (esp = {$esp}) 
              and (min = {$_POST['gender']}) 
              and (shlilotM = {$_POST['license-suspensions']}) 
              and (month = {$month}) 
              and (year = {$year}) 
              and (fromDay <= {$day}) 
              and (lastDay >= {$day}) 
              ORDER BY privatePrice DESC";
//	echo '<pre style="direction: ltr;">';
//	var_dump($query);
//	echo '</pre>';
	$result = $wpdb->get_results( $query, ARRAY_A );

	return $result;
}

/**
 * Get zad g insurance from DB
 *
 * @param $compId
 * @param $ins_period
 *
 * @return array|null|object
 */
function sogo_get_zad_g( $comp_id, $ins_period, $vehicle_year ) {

	$code_levi = sogo_get_levi_code();

	//remove all leading zeros from levi code
	$code_levi = ltrim( $code_levi, '0' );

	//if code levi length is 7 its commercial vehicle type, else its private
	$vehicle_type_by_levi = strlen( $code_levi );
	$vehicle_type_by_levi = $vehicle_type_by_levi != 7 ? 1 : 2;

	$time_zone = new DateTimeZone( 'Asia/Jerusalem' );

	$car_year     = DateTime::createFromFormat( 'Y', $vehicle_year, $time_zone );
	$current_year = new DateTime;
	$current_year->format( "Y" );
	//get car age
	$car_age = $current_year->diff( $car_year )->y;

	$year_taarif  = (int) $ins_period->format( 'Y' );
	$month_taarif = (int) $ins_period->format( 'm' );

	$law_suites = 0;

	//validate of sequence of law suites
	switch ( $_POST['law-suite-what-year'] ) {
		case '1':
			$law_suites = 1;
			break;
		case '2':
			if ( empty( $_POST['insurance-1-year'] ) || $_POST['insurance-1-year'] == '3' ) {
				$law_suites = 0;
			}
			break;
		case '3':
			if ( empty( $_POST['insurance-1-year'] ) ) {
				$law_suites = 0;
			}
			break;
	}

	global $wpdb;

	$query = "SELECT DISTINCT * FROM wp_zad_g 
              WHERE (compId IN ({$comp_id} )) 
              and  (startAge <= {$_POST['youngest-driver']} or startAge = -1) 
              and (endAge >= {$_POST['youngest-driver']} or endAge = -1) 
              and (startVetek <= {$_POST['lowest-seniority']} or startVetek = -1) 
              and (endVetek >= {$_POST['lowest-seniority']} or endVetek = -1) 
              and carType = {$vehicle_type_by_levi} 
              and (startCarAge <= {$car_age} or startCarAge = -1) 
              and (endCarAge >= {$car_age} or endCarAge = -1) 
              and (ownerShip = {$_POST['ownership']} or ownerShip = -1) 
             #and (startHiaderTviot <= {$law_suites}) 
                           #and (endHiaderTviot >= {$law_suites}) 
              and (startDrivers <= {$_POST['drive-allowed-number']}) 
              and (endDrivers >= {$_POST['drive-allowed-number']}) 
              and (yearTaarif={$year_taarif} or yearTaarif= -1) 
              and (monthTaarif={$month_taarif} or monthTaarif= -1) 
              ORDER BY (priceNormal + havila) ASC";
//	echo '<pre style="direction: ltr;">';
//	var_dump($query);
//	echo '</pre>';
	/*$query = "SELECT DISTINCT * FROM wp_zad_g
		  WHERE (compId = {$comp_id} )
		  and  (startAge <= {$_POST['youngest-driver']} or startAge = -1)
		  and (endAge >= {$_POST['youngest-driver']} or endAge = -1)
		  and (startVetek <= {$_POST['lowest-seniority']} or startVetek = -1)
		  and (endVetek >= {$_POST['lowest-seniority']} or endVetek = -1)
		  and carType = {$vehicle_type_by_levi}
		  and (startCarAge <= {$car_age} or startCarAge = -1)
		  and (endCarAge >= {$car_age} or endCarAge = -1)
		  and (ownerShip = {$_POST['ownership']} or ownerShip = -1)
		 #and (startHiaderTviot <= {$law_suites})
					   #and (endHiaderTviot >= {$law_suites})
		  and (startDrivers <= {$_POST['drive-allowed-number']})
		  and (endDrivers >= {$_POST['drive-allowed-number']})
		  and (yearTaarif={$year_taarif} or yearTaarif= -1)
		  and (monthTaarif={$month_taarif} or monthTaarif= -1)
		  ORDER BY (priceNormal + havila) ASC";*/

	$result = $wpdb->get_results( $query, ARRAY_A );
//	echo '<pre style="direction: ltr;">';
//	var_dump($result);
//	echo '</pre>';
	return $result;
}

/**
 * @param $data
 *
 * @return array|null|object
 */
function sogo_get_insurance_terms( $data ) {
	global $wpdb;

	$query = "SELECT id, branch_name, insurance_period, message FROM wp_insurance_terms_manage 
              WHERE STR_TO_DATE(insurance_period, '%d.%m.%Y') <= STR_TO_DATE('{$data['insurance_period']}', '%d/%m/%Y') 
              and insurance_company = {$data['insurance_company']} 
              and vehicle_type = '{$data['vehicle_type']}' 
              and from_age <= {$data['from_age']} 
              and to_age >= {$data['to_age']} 
              and from_seniority <= {$data['from_seniority']} 
              and to_seniority >= {$data['to_seniority']} 
              ORDER BY insurance_period ASC LIMIT 1";
	$result = $wpdb->get_results( $query, ARRAY_A );

	return $result;
}

/**
 * Send email
 *
 * @param $email
 * @param $subject
 * @param $message
 */
function sogo_send_email( $email, $subject, $message ) {

	$headers = array( 'Content-Type: text/html; charset=UTF-8' );

	return wp_mail( $email, $subject, apply_filters( 'the_content', $message ), $headers );
}

function sogo_send_insurance_no_results() {
	//verify if we get all params from form
	if ( ! isset( $_POST['params'] ) || empty( $_POST['params'] ) ) {
		wp_send_json( array( 'message' => __( 'You don`t have permission to do that', 'sogoc' ), 'status' => '0' ) );
	}

	parse_str( $_POST['params'], $insurance_data );//parsing data from ajax
//	echo '<pre style="direction: ltr;">';
//	var_dump($insurance_data);
//	echo '</pre>';
	$message = '<table style="border: 1px solid #000000">';

	foreach ( $insurance_data as $key => $data ) {
		$last_data = sogo_set_translate_name_for_no_results( $key, $data );

		$message .= '<tr>';
		$message .= '<td>' . $last_data[0] . ' - ' . $last_data[1] . '</td>';
		$message .= '</tr>';
	}

	$message .= '<tr>
                            <td>קישור להצעה:</td>
                            <td><a target="_blank" href="' . $insurance_data['ins_link'] . '?ins_order=' . $insurance_data['ins_order'] . '">לחץ כאן</a></td>
                        </tr>
                   </table>';

//	sogo_send_email( 'alex@sogo.co.il, sami@hova.co.il', 'לקוח התעניין בהצעה', $message );
	sogo_send_email( 'info@hova.co.il,sami.henn@gmail.com,sales@hova.co.il', 'לקוח התעניין בהצעה', $message );

	wp_send_json( array( 'message' => __( 'Insurance params was send successfully', 'sogoc' ), 'status' => '1' ) );
}

add_action( 'wp_ajax_sogo_send_insurance_no_results', 'sogo_send_insurance_no_results' );
add_action( 'wp_ajax_nopriv_sogo_send_insurance_no_results', 'sogo_send_insurance_no_results' );

function sogo_set_translate_name_for_no_results( $name, $value = false ) {
	switch ( $name ) {
		case 'ins_order':
			return array( 'מספר הזמנה', $value );
		case 'ownership-date':
			$value = $value == '1' ? 'פחות משנה' : 'מעל שנה';

			return array( 'ממתי הרכב בבעלותך', $value );
		case 'ins_link':
			return array( 'קישור להזמנה', $value );
		case 'insurance-date-start':
			return array( 'תחילת ביטוח', $value );
		case  'insurance-date-finish':
			return array( 'סיום ביטוח', $value );
		case  'vehicle-manufacturer':
			return array( 'יצרן', $value );
		case  'vehicle-year':
			return array( 'שנת ייצור', $value );
		case  'vehicle-brand':
			return array( 'דגם', $value );
		case  'vehicle-sub-brand':
			return array( 'דגם משנה', $value );
		case  'gears':
			$value = $value == '1' ? 'ידני' : 'אוטומטי';

			return array( 'הילוכים', $value );
		case  'ownership':
			$value = $value == '1' ? 'פרטית' : 'אחר';

			return array( 'בעלות הרכב', $value );
		case  'keeping-distance-system':
			$value = $value == '1' ? 'כן' : 'לא';

			return array( 'מערכת שמירת מרחק', $value );
		case  'deviation-system':
			$value = $value == '1' ? 'כן' : 'לא';

			return array( 'מערכת סטיה מנתיב', $value );
		case  'youngest-driver':
			return array( 'גיל הנהג הצעיר ביותר', $value );
		case  'lowest-seniority':
			return array( 'וותק הנהיגה הנמוך ביותר', $value );
		case  'drive-allowed-number':
			switch ( $value ) {
				case '1':
					$value = 'נהג יחיד';
					break;
				case '2':
					$value = '2 נהגים';
					break;
				case '3':
					$value = '3 נהגים';
					break;
				case '4':
					$value = 'כל נהג';
					break;
			}

			return array( 'מספר הרשאים לנהוג', $value );
		case  'gender':
			$value = $value == '1' ? 'זכר' : 'נקבה';

			return array( 'מין הנהג הצעיר ביותר', $value );
		case  'insurance-before':
			$value = $value == '1' ? 'כן' : 'לא';

			return array( 'האם היה ביטוח קודם', $value );
		case  'insurance-1-year':
			switch ( $value ) {
				case '1':
					$value = 'מקיף';
					break;
				case '2':
					$value = 'צד ג';
					break;
				case '3':
					$value = 'לא היה';
					break;
			}

			return array( 'לפני שנה', $value );
		case  'insurance-2-year':
			switch ( $value ) {
				case '1':
					$value = 'מקיף';
					break;
				case '2':
					$value = 'צד ג';
					break;
				case '3':
					$value = 'לא היה';
					break;
			}

			return array( 'לפני שנתיים', $value );
		case  'insurance-3-year':
			switch ( $value ) {
				case '1':
					$value = 'מקיף';
					break;
				case '2':
					$value = 'צד ג';
					break;
				case '3':
					$value = 'לא היה';
					break;
			}

			return array( 'לפני 3 שנים', $value );
		case  'law-suites-3-year':
			switch ( $value ) {
				case '0':
					$value = 'לא היו';
					break;
				case '1':
					$value = 'תביעה 1';
					break;
			}

			return array( 'האם היו לך תביעות 3 שנים אחרונות', $value );
		case  'law-suite-what-year':
			switch ( $value ) {
				case '1':
					$value = 'שנה אחרונה';
					break;
				case '2':
					$value = 'לפני שנתיים';
					break;
				case '3':
					$value = 'לפני שלוש שנים';
					break;
			}

			return array( 'באיזה שנה היתה התביעה', $value );
		case  'body-claims':
			switch ( $value ) {
				case '1':
					$value = 'שנה אחרונה';
					break;
				case '2':
					$value = 'לפני שנתיים';
					break;
				case '3':
					$value = 'לפני שלוש שנים';
					break;
			}

			return array( 'תביעות גוף', $value );
		case  'criminal-record':
			$value = $value == '1' ? 'כן' : 'לא';

			return array( 'נוסע בשבת', $value );
		case  'drive-on-saturday':
			$value = $value == '1' ? 'כן' : 'לא';

			return array( ' עבר פלילי', $value );
		case  'license-suspensions':
			switch ( $value ) {
				case '0':
					$value = '0';
					break;
				case '1':
					$value = '1';
					break;
			}

			return array( 'שלילות רשיון', $value );
		case  'city':
			return array( 'עיר מגורים', $value );
		case  'contact-compare-name-2-1':
			return array( 'שם מלא', $value );
		case  'contact-compare-phone-1':
			return array( 'טלפון', $value );
		case 'more-details':
			return [ '<h2>פרטים נוספים:</h2>', '' ];

	}
}

/**
 * Send Insurance offer to user email
 */
function sogo_send_insurance_offer() {
	$full_name = $_POST['full_name'];
	$message   = '';
//	$message = 'שלום ' . $full_name . '<br />';

	$ins_link     = $_POST['ins_link'];
	$email        = $_POST['email'];
	$phone        = isset( $_POST['phone'] ) ? $_POST['phone'] : false;
	$type_of_form = isset( $_POST['type_of_form'] ) ? $_POST['type_of_form'] : false;

	$lidMethodValue = ( isset( $phone ) && ! empty( $phone ) ? $phone : $email );

	$lidArr = [
		'lid_name'         => $full_name,
		'lid_method_value' => $lidMethodValue,
		'lid_link'         => $ins_link
	];

	$post = http_build_query( $lidArr );

	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, 'http://crm.hova.co.il/crm/save-lid?' );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	$result = curl_exec( $ch );
	curl_close( $ch );

	if ( $type_of_form === 'one' ) {
		// if send the proposal by mail
		$message = get_field( '_sogo_text_for_mail_insurance', 'option' );
		$message .= '<br /><a target="_blank" href="' . $ins_link . '">לחץ כאן</a>';

		sogo_send_email( $email, 'הצעה שלך למייל מאתר חובה', $message );

		wp_send_json_success( array( 'message' => 'email send success', 'type' => 'one', 'link' => $ins_link ) );
	} else {
		// if send the phone number to hova
		$message = '<table style="border: 1px solid #000000">
                        <tr>                        
                            <td>שם:</td>                            
                            <td>' . $full_name . '</td>
                        </tr>
                        
                        <tr>
                            <td>טלפון:</td>
                            <td>' . $phone . '</td>

                        </tr>
                        
                        <tr>
                            <td>קישור להצעה:</td>
                            <td><a target="_blank" href="' . $ins_link . '">לחץ כאן</a></td>
                        </tr>
                   </table>';


		if ( sogo_send_email( 'info@hova.co.il,sami.henn@gmail.com,sales@hova.co.il', 'לקוח התעניין בהצעה', $message ) ) {
			wp_send_json_success( array( 'message' => 'email send success', 'type' => 'two' ) );
		}
	}

}
add_action( 'wp_ajax_sogo_send_insurance_offer', 'sogo_send_insurance_offer' );
add_action( 'wp_ajax_nopriv_sogo_send_insurance_offer', 'sogo_send_insurance_offer' );



//insert streets to db once
function sogo_insert_city_street_to_db() {
	$url = 'https://data.gov.il/dataset/785ad9fb-6da6-426d-b5ea-b8e36febbc8a/resource/2f9c3a0d-bcdc-4539-b626-a8d708ed98d8/download/rechovot220180601.xml';
	$xml = simplexml_load_file( $url ) or die( "feed not loading" );

	global $wpdb;

	$city_code   = '';
	$city_name   = '';
	$street_name = '';

	foreach ( $xml as $key => $row ) {

		foreach ( $row->city_code as $item ) {
			$city_code = trim( $item );
		}

		foreach ( $row->city_name as $item ) {
			$city_name = trim( $item );
		}

		foreach ( $row->street_name as $item ) {
			$street_name = trim( $item );
		}

		$wpdb->insert( 'wp_street_and_city', array(
			'city_code'   => $city_code,
			'city_name'   => $city_name,
			'street_name' => $street_name
		) );
	}

	die();
}



function sogo_autocomplete_street() {
	$city          = $_POST['city'];
	$street_string = $_POST['street_string'];

	global $wpdb;

	$query = "SELECT street_name FROM wp_street_and_city WHERE city_name = '{$city}' AND street_name LIKE '{$street_string}%'";

	$result = $wpdb->get_results( $query, ARRAY_A );

	wp_send_json( $result );
}

add_action( 'wp_ajax_sogo_autocomplete_street', 'sogo_autocomplete_street' );
add_action( 'wp_ajax_nopriv_sogo_autocomplete_street', 'sogo_autocomplete_street' );

/**
 * Store insurance params in options DB
 */
function sogo_store_insurance_params() {
	session_start();

	//for override those fields in session
	$owerrideFieldsArr = [
		'youngest-driver',
		'lowest-seniority',
		'drive-allowed-number'
	];

	$wipeDriversFieldsArr = [
		'driver-first-name',
		'driver-last-name',
		'driver-identical-number',
		'driver-birthday',
		'driver-gender',
		'years-issuing-license',
	];
	//erase current session fields of upsales and drivers info , depend on isurance chose and count drivers in car
	$wipeUpsalesFieldsArr = [
		'upsales-product-name',
		'upsales-product-description',
	];


	$ins_order = null;

	parse_str( $_POST['insurance_data'], $insurance_data );//parsing data from ajax

	$ins_order = $insurance_data['ins_order'];


	//change count drivers info if it change and youngest driver and lowest seniority
	if ( isset( $_SESSION['ins_orders'][ $ins_order ]['params'] ) ) {

		//$countDriversInSession = 3;
		$countDriversInSession = (int) $_SESSION['ins_orders'][ $ins_order ]['params']['order_details']['drive-allowed-number'];
		$countDriversInOrder   = (int) $insurance_data['drive-allowed-number'];

		//check if number drivers is changed and it is less than it been an not selected that any one can drive
		if ( $countDriversInSession > $countDriversInOrder ) {

			$countDrivers = $insurance_data['drive-allowed-number'];

			//if insurance owner also drive we cut one more driver
			if ( (int) $_SESSION['ins_orders'][ $ins_order ]['params']['drive-allowed'] === 1 ) {
				$countDrivers = (int) $countDrivers - 1;
			}

			//calculating new drivers info, depend on new count drivers
			foreach ( $_SESSION['ins_orders'][ $ins_order ]['params'] as $key => $param ) {
				if ( in_array( $key, $wipeDriversFieldsArr ) ) {
					@array_splice( $_SESSION['ins_orders'][ $ins_order ]['params'][ $key ], $countDrivers, $countDriversInSession );
				}
			}

		}

		//override driver info like lowest seniority and allowed to drive and youngest driver
		$params = $_SESSION['ins_orders'][ $ins_order ]['params']['order_details'];

		foreach ( $params as $orderKey => $param ) {

			if ( in_array( $orderKey, $owerrideFieldsArr ) ) {
				$_SESSION['ins_orders'][ $ins_order ]['params']['order_details'][ $orderKey ] = $insurance_data[ $orderKey ];
			}
		}
	}

	//check if insurance type was changed , and if yes we wipe all upsales of earlier insurance
	$sessionInsType = $_SESSION['ins_orders'][ $ins_order ]['params']['order_details']['in_type'];
	$orderInsType   = $_SESSION['ins_orders'][ $ins_order ]['ins_type'];

	if ( (int) $sessionInsType !== (int) $orderInsType ) {

		foreach ( $_SESSION['ins_orders'][ $ins_order ]['params'] as $upsaleKey => $upsaleValue ) {
			if ( preg_match( '/upsale_/', $upsaleKey ) ) {
				unset( $_SESSION['ins_orders'][ $ins_order ]['params'][ $upsaleKey ] );
			}
		}
	}

	//check if youngest driver age is changed, if yes wipe youngest driver birthday
	$sessionYoungestDriver = (int) $_SESSION['ins_orders'][ $ins_order ]['params']['order_details']['youngest-driver'];
	$orderYoungestDriver   = (int) $insurance_data['youngest-driver'];

	if ( $sessionYoungestDriver !== $orderYoungestDriver ) {
		$_SESSION['ins_orders'][ $ins_order ]['params']['birthday-date'] = null;
	}

	$insurance_data['insurance-type']                                           = $insurance_data['in_type'];
	$order_data['order_details']                                                = $insurance_data;
	$_SESSION['ins_orders'][ $ins_order ]['params']['order_details']['in_type'] = $_SESSION['ins_orders'][ $ins_order ]['ins_type'];//setting up insurance type if changed to avoid wrong insurance calculation


	$result                                         = update_option( 'insurance-order_' . $ins_order, $order_data );
	$_SESSION['ins_orders'][ $ins_order ]['params'] = $order_data;

	$return = array(
		'result'          => $result,
		'insurance_order' => $ins_order
	);


	wp_send_json( $return );
}

add_action( 'wp_ajax_sogo_store_insurance_params', 'sogo_store_insurance_params' );
add_action( 'wp_ajax_nopriv_sogo_store_insurance_params', 'sogo_store_insurance_params' );

/**
 * Send order insurance for pay
 */
function sogo_send_order_data() {

	if ( ! isset( $_SESSION ) || empty( $_SESSION ) ) {
		session_start();
	}

	if ( empty( $_SESSION ) ) {
		$response = [
			'link'      => site_url( '/' ),
			'ins_order' => 'false'

		];

		wp_send_json( $response );
		die();
	}


	$cardInfoKeys = [
		'cardholder-name',
		'cardholder-id',
		'card-number',
		'card-month',
		'card-year',
		'mandat-price',
		'second-price',
		'upsales-price',
		'package-price',
		'mandat-num-payments',
		'other-num-payments',
		'upsales-number-payments',
		'havila-num-payments',
		'ins-company',
	];


	$customerInfoKeysArr = [
		'license-number',
		'ownership-date',
		'ownership-under-year',
		'first-name',
		'last-name',
		'identical-number',
		'birthday-date',
		'license-year',
		'gender',
		'drive-allowed',
		'mobile-phone-number',
		'email',
		'additional-phone-number',
		'city',
		'street',
		'house-number',
		'apartment-number',
		'use-another-address',
		'city-another',
		'street-another',
		'house-number-another',
		'apartment-number-another',
		'ins-type',
		'ins-order',
		'policy-send',
		'tac-1',
	];


	parse_str( $_POST['order_data'], $order_data );
//	if (isset($_COOKIE['dev'])) {
//		echo '<pre style="direction: ltr;">';
//		var_dump($_POST['order_data']);
//		echo '</pre>';
//		die();
//	}
	$ins_order = $_SESSION['ins_orders'][ $order_data['ins-order'] ]['id'];

	$order_params = get_option( 'insurance-order_' . $ins_order );
	$params       = array_merge( $order_params, $order_data );
	$dbParams     = [];

	//remove credit card info from db of wordpress
	foreach ( $params as $key => $param ) {
		if ( in_array( $key, $cardInfoKeys ) ) {
			$dbParams[ $key ] = '';
		} else {
			$dbParams[ $key ] = $param;
		}
	}

	delete_option( 'insurance-order_' . $ins_order );
	update_option( 'insurance-order_' . $ins_order, $dbParams );

	$driversInfoArr             = [];
	$upsalesArr                 = [];
	$customerArr                = [];
	$paymentInfoArr             = [];
	$paymentInfoArr['editMode'] = false;

	//collecting together all info of allowing drivers together
	foreach ( $order_data as $orderPart => $data ) {

		if ( is_array( $data ) && $orderPart != 'upsales-product-description' && $orderPart != 'upsales-product-name' ) {

			foreach ( $data as $key => $val ) {
				if ( empty( $data[ $key ] ) ) {
					continue;
				}
				$driversInfoArr[ $key ][] = $data[ $key ];
			}
		} else if ( is_array( $data ) ) {
			foreach ( $data as $key => $val ) {
				$upsalesArr[ $key ][] = $data[ $key ];
			}

		} else {

			if ( in_array( $orderPart, $customerInfoKeysArr ) ) {

				if ( $orderPart === 'ins-type' ) {
					$customerArr[ $orderPart ] = ( isset( $_SESSION['ins_orders'][ $ins_order ]['ins_type'] ) ? $_SESSION['ins_orders'][ $ins_order ]['ins_type'] : $data );
				} else {

					$customerArr[ $orderPart ] = $data;
				}
			}

		}
	}

	$ind = 0;
	foreach ( $driversInfoArr as $param => $info ) {

		if ( $param == 0 ) {
			$ind = 2;
		} else if ( $param == 1 ) {
			$ind = 3;
		}

		$driversInfoArr[ $param ][] = $order_data[ 'driver-identical-number_' . $param ];//appending driver I.D
	}

	$cardInfoKeys = [
		'cardholder-name',
		'cardholder-id',
		'card-number',
		'card-month',
		'card-year',
		'mandat-price',
		'second-price',
		'upsales-price',
		'package-price',
		'mandat-num-payments',
		'other-num-payments',
		'upsales-number-payments',
		'havila-num-payments',
		'ins-company',
	];


	//check the chosed company id and getting prices of insurance
	$companyID = $order_params['order_details']['company_id'];


	//check if sessions exists
	$affId   = 0;//id of an agent, that open new order from crm
	$fromSrc = 0;//from where surfing source is? CRM? IFRAME?
	$ai      = 0;//id of agent that edit order details
	if ( isset( $_SESSION['aff'] ) ) {
		$affId = (int) $_SESSION['aff'];
	}

	if ( isset( $_SESSION['src'] ) ) {
		$fromSrc = $_SESSION['src'];
	}

	if ( isset( $_SESSION['ai'] ) ) {
		$ai = (int) $_SESSION['ai'];
	}

	$companies       = json_decode( $_SESSION['avaliableCompanies'] );
	$selectedCompany = [];

	include dirname( __FILE__ ) . "/lib/SogoInsurance.php";
	include dirname( __FILE__ ) . "/lib/Encryption.Class.php";
	$insurance    = new SogoInsurance( [] );
	$insCompanies = $insurance->get_insurance_companies();

	//for parse payment info (phone or credit-card)
	$finalPrice = null;
	$tmpPrice   = null;

	if ( preg_match( '/,/', $order_params['order_details']['company_id'] ) ) {
		//0 = id of mandatory company
		//1 = id of third party company
		$id_mandatory   = explode( ',', $order_params['order_details']['company_id'] )[0];
		$id_third_party = explode( ',', $order_params['order_details']['company_id'] )[1];

		foreach ( $companies as $index => $company ) {

			if ( isset( $company->mandatory_company_id ) && (int) $id_mandatory === (int) $company->mandatory_company_id && (int) $id_third_party === $company->company_id ) {

				$selectedMixCompany = $company;

			}
		}

		$mandatoryPrice = (int) isset( $selectedMixCompany->mandatory ) ? $selectedMixCompany->mandatory : $selectedMixCompany->price;//if is mandatory insurance we take only price
		$insurancePrice = (int) $selectedMixCompany->comprehensive_normal;

		$havila               = (int) $selectedMixCompany->price_havila;
		$numPaymentsNoPresent = (int) $insCompanies[ $id_third_party ]['other_num_payments_no_percents'];

	} else {

		//session_unset();
		//getting info of selected company
		foreach ( $companies as $index => $company ) {
			if ( $companyID == $company->company_id && ! isset( $company->comprehensive_normal ) ) {
				$selectedCompany = $company;
			}
		}

		$mandatoryPrice = (int) isset( $selectedCompany->mandatory ) ? $selectedCompany->mandatory : $selectedCompany->price;//if is mandatory insurance we take only price
		$insurancePrice = (int) $selectedCompany->comprehensive;


		$havila               = (int) $selectedCompany->price_havila;
		$numPaymentsNoPresent = (int) $insCompanies[ $companyID ]['other_num_payments_no_percents'];
	}

	$upsalesTitle         = 'upsale_';
	$upsalesTmArr         = [];
	$upsales              = [];
	$mandatoryNumPayments = ++ $order_data['mandat-num-payments'];
	$insuranceNumPayments = isset( $order_data['other-num-payments'] ) && (int) $order_data['other-num-payments'] >= 0 ? ++ $order_data['other-num-payments'] : 0;
	$upsalesNumPayments   = isset( $order_data['upsales-number-payments'] ) && (int) $order_data['upsales-number-payments'] >= 0 ? ++ $order_data['upsales-number-payments'] : 0;
	$havilaNumPayments    = isset( $order_data['havila-num-payments'] ) && (int) $order_data['havila-num-payments'] >= 0 ? ++ $order_data['havila-num-payments'] : 0;

	if ( $havila > 0 ) {
		$insurancePrice -= $havila;
	}

	//check if insurance number payments is with no percents, else add 3% over
	if ( $insuranceNumPayments > $numPaymentsNoPresent ) {

		$tmpPrice   = ( $insurancePrice * 0.03 );
		$finalPrice = ceil( $tmpPrice + $insurancePrice );
	} else {
		$finalPrice = $insurancePrice;
	}

	$cardNumber = str_replace( range( 0, 9 ), "#", substr( $order_data['card-number'], 0, - 4 ) ) . substr( $order_data['card-number'], - 4 );

	//if is telephone order
	if ( isset( $order_data['use-phone-payment'] ) && $order_data['use-phone-payment'] === 'on' ) {

//		$paymentInfoArr['cardholder-name']         = '';
//		$paymentInfoArr['cardholder-id']           = '';
//		$paymentInfoArr['card-owner-token']        = '';
//		$paymentInfoArr['card-owner-key']          = '';
//		$paymentInfoArr['card-number']             = '';
//		$paymentInfoArr['cardholder-year']         = '';
//		$paymentInfoArr['cardholder-month']        = '';
		$paymentInfoArr['mandat-price']  = $mandatoryPrice;
		$paymentInfoArr['second-price']  = (int) $_SESSION['ins_orders'][ $ins_order ]['ins_type'] !== 1 ? $finalPrice : 0;
		$paymentInfoArr['package-price'] = (int) $_SESSION['ins_orders'][ $ins_order ]['ins_type'] !== 1 ? $havila : 0;
		//$paymentInfoArr['mandat-num-payments']     = $mandatoryNumPayments;
		//$paymentInfoArr['havila-num-payments']     = $havilaNumPayments;
		//$paymentInfoArr['upsales-number-payments'] = $upsalesNumPayments;
		//$paymentInfoArr['other-num-payments']      = $insuranceNumPayments;
		$paymentInfoArr['ins-company'] = isset( $order_data['ins-company'] ) && ! empty( $order_data['ins-company'] ) ? $order_data['ins-company'] : $params['order_details']['ins_company'];


		//if order was edited by agent
	} else {

		$encryptionKey = openssl_random_pseudo_bytes( 16 );
		$encryptor     = new Encryption( $encryptionKey );

		$paymentInfoArr['cardholder-name']         = $order_data['cardholder-name'];
		$paymentInfoArr['cardholder-id']           = $order_data['cardholder-id'];
		$paymentInfoArr['card-owner-token']        = $encryptor->encrypt( $order_data['card-number'] );
		$paymentInfoArr['card-owner-key']          = base64_encode( $encryptionKey );
		$paymentInfoArr['card-number']             = $cardNumber;
		$paymentInfoArr['cardholder-year']         = $order_data['card-year'];
		$paymentInfoArr['cardholder-month']        = $order_data['card-month'];
		$paymentInfoArr['mandat-price']            = $mandatoryPrice;
		$paymentInfoArr['second-price']            = $finalPrice;
		$paymentInfoArr['package-price']           = $havila;
		$paymentInfoArr['mandat-num-payments']     = $mandatoryNumPayments;
		$paymentInfoArr['havila-num-payments']     = $havilaNumPayments;
		$paymentInfoArr['upsales-number-payments'] = $upsalesNumPayments;
		$paymentInfoArr['other-num-payments']      = $insuranceNumPayments;
		$paymentInfoArr['ins-company']             = isset( $order_data['ins-company'] ) && ! empty( $order_data['ins-company'] ) ? $order_data['ins-company'] : $params['order_details']['ins_company'];
	}

	if ( (int) $ai !== 0 ) {
		$paymentInfoArr['editMode'] = $order_data['true'];
	}

	//check if customer chose usales
	foreach ( $order_data as $ins => $data ) {
		//if there is upsales we get they id for gewt them from upsales array
		if ( preg_match( '/' . $upsalesTitle . '/', $ins ) && ( $data == 'on' ) ) {
			$id             = explode( '_', $ins )[1];
			$upsalesTmArr[] = $id;
		}
	}

	//getting upslaes if chosen
	if ( ! empty( $upsalesTmArr ) && ( isset( $upsalesTmArr[0] ) && ! is_null( $upsalesTmArr[0] ) ) ) {

		$upsalesArr = get_field( 'insurance_upsales', 'options' );

		foreach ( $upsalesArr as $upsale => $info ) {
			if ( in_array( $info['upsale_sku'], $upsalesTmArr ) ) {
				$upsales[] = $info;
			}
		}
	}

	foreach ( $order_data as $order => $info ) {
		if ( in_array( $order, $cardInfoKeys ) && ! empty( $order ) ) {
			$orderInfoArr['paymentInfo'][ $order ] = $info;
		}
	}

	//fix wrong number payments of up sales if there is no up sales chosen
	$paymentInfoArr['upsales-number-payments'] = ( is_null( $upsales ) || empty( $upsales ) ? 0 : $paymentInfoArr['upsales-number-payments'] );

	$insuranceParamsKeysArr = [
		'ins_order',
		'in_type',
		'insurance-date-start',
		'insurance-date-finish',
		'vehicle-manufacturer',
		'vehicle-year',
		'vehicle-brand',
		'vehicle-sub-brand',
		'engine_capacity',
		'esp',
		'fcw',
		'ldw',
		'levi-code',
		'ownership',
		'keeping-distance-system',
		'deviation-system',
		'gender',
		'youngest-driver',
		'lowest-seniority',
		'drive-allowed-number',
		'insurance-before',
		'body-claims',
		'insurance-1-year',
		'insurance-2-year',
		'insurance-3-year',
		'law-suites-3-year',
		'law-suite-what-year',
		'criminal-record',
		'drive-on-saturday',
		'license-suspensions',
		'city',
		'tac-1',
		'tac',
		'add_info',
	];

	foreach ( $order_params['order_details'] as $ins => $part ) {

		if ( in_array( $ins, $insuranceParamsKeysArr ) && ! empty( $ins ) ) {
			$finalInfoArray['insuranceIfo'][ $ins ] = $part;
			//if ins_order come empty
		} else if ( in_array( $ins, $insuranceParamsKeysArr ) && $ins === 'ins_order' ) {
			$finalInfoArray['insuranceIfo'][ $ins ] = $_SESSION['ins_orders'][ $ins_order ]['id'];
		}
	}

	// set insurance type from session
	$finalInfoArray['insuranceIfo']['ins_type'] = $_SESSION['ins_orders'][ $ins_order ]['ins_type'];

	$useragent = $_SERVER ['HTTP_USER_AGENT'];

	//catching surfing source.
	if ( preg_match( '/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent ) || preg_match( '/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr( $useragent, 0, 4 ) ) ) {
		$surfingSource = 'mobile';
	} else {
		$surfingSource = 'web';
	}

	$userIp = urlencode( $_SERVER['REMOTE_ADDR'] );

	$finalInfoArray['drivers']       = $driversInfoArr;
	$finalInfoArray['upsales']       = ! is_null( $upsales ) ? $upsales : 'empty';
	$finalInfoArray['customer']      = $customerArr;
	$finalInfoArray['token']         = $paymentInfoArr;
	$finalInfoArray['surfingSource'] = $surfingSource;
	$finalInfoArray['affId']         = $affId;
	$finalInfoArray['ai']            = $ai;
	$finalInfoArray['fromSrc']       = $fromSrc;
	$finalInfoArray['userAgent']     = urlencode( $useragent );
	$finalInfoArray['userIp']        = $userIp;
	$finalInfoArray['ins_link']      = $_SERVER['SERVER_NAME'];
	$url                             = "http:/crm.hova.co.il/crm/public/new-deal?";
	$finalOrderArr                   = [];
	$finalOrderArr['order']          = $finalInfoArray;

	$ins_type = $finalInfoArray['insuranceIfo']['ins_type'];

	$customerEmail = $finalInfoArray['customer']['email'];
	$msg           = '';

	switch ( (int) $ins_type ) {
		case 1:
			$msg = get_field( 'sogo_mandatory_insurance_email_body', 'options' );
			break;
		case 2:
			$msg = get_field( 'sogo_comprehensive_insurance_email_body', 'options' );
			break;
		case 3:
			$msg = get_field( 'sogo_zad_g_insurance_email_body', 'options' );
			break;
	}

	$link_page = get_field( '_sogo_link_to_thank_' . $ins_type, 'option' );

	$finalOrderArr['order']['orderAddInfo'] = isset( $order_params['order_details']['add_info'] ) && ! empty( $order_params['order_details']['add_info'] ) ?
        $order_params['order_details']['add_info'] : 'נא למלא מידע נוסף בבסיס נתונים';

	//mail('victor@sogo.co.il', 'hova order debug info', var_export($finalOrderArr, true));
	$post = http_build_query( $finalOrderArr );

	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	$result = curl_exec( $ch );

	curl_close( $ch );

	$result = json_decode( $result );

	$orderStatus = $result->orderStatus;
	$order_id    = $result->orderId;

	//Add order_id to translated fields of order info
	$finalInfoArray['insuranceIfo']['order_id'] = $order_id;

	//replacing order info shortcodes
	foreach ( $finalInfoArray as $param => $info ) {

		if ( is_array( $info ) ) {
			foreach ( $info as $key => $val ) {
				$msg = str_replace( '@' . $key . '@', $val, $msg );
			}
		}
	}


	$message = "<html>";
	$message .= "<head>";
	$message .= "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=UTF-8\">";
	$message .= "</head>";
	$message .= "<body dir='rtl' >";
	$message .= '<div style="direction: rtl;">';
	$message .= "<p>";
	$message .= "<div style='font-size: 1.2em;' dir='rtl'>";
//	$message .= "<table border='1' cellpadding='2' cellspacing='1' dir='rtl' style='font-family: Arial; font-size: 16px; background: #F8EFBA; color: #2C3A47;'>";

	$message .= $msg;

//	$message .= "</table>";
	$message .= "</div>";
	$message .= "<p>";
	$message .= '</div>';
	$message .= "</body>";
	$message .= "</html>";

	$emails  = 'info@hova.co.il,' . $finalInfoArray['customer']['email'];
	$emails2 = 'info@hova.co.il';

	$response = [
		'ins_order' => $ins_order,
		'link'      => $link_page,
		'order_id'  => $order_id,
	];

	//for hova only, not customer
	$message2 = "<html>";
	$message2 .= "<head>";
	$message2 .= "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=UTF-8\">";
	$message2 .= "</head>";
	$message2 .= "<body dir='rtl' >";
	$message2 .= '<div style="direction: rtl;">';
	$message2 .= "<p>";
	$message2 .= "<div style='font-size: 1.2em;' dir='rtl'>";
//	$message .= "<table border='1' cellpadding='2' cellspacing='1' dir='rtl' style='font-family: Arial; font-size: 16px; background: #F8EFBA; color: #2C3A47;'>";

	$message2 .= "<div>
    <p> <span> שם לקוח :  </span> <span>{$finalInfoArray['customer']['first-name']} {$finalInfoArray['customer']['last-name']}</span></p>
    <p> <span> מייל :  </span> <span>{$finalInfoArray['customer']['email']}</span></p>
    <p> <span> טל :  </span> <span>{$finalInfoArray['customer']['mobile-phone-number']} </span></p>
    <p> <span> מס הזמנה :  </span> <span>{$order_id} </span></p>
    <p> <span> ins_order :  </span> <span>{$ins_order} </span></p>

</div>";

//	$message .= "</table>";
	$message2 .= "</div>";
	$message2 .= "<p>";
	$message2 .= '</div>';
	$message2 .= "</body>";
	$message2 .= "</html>";

	sogo_send_email( $emails2, ' אישור קליטת הזמנה  באתר חובה ', $message2 );

	if ( $orderStatus === 'existing' ) {
		wp_send_json( $response );

	} else {
		if ( sogo_send_email( $emails, ' אישור קליטת הזמנה ' . $order_id . ' באתר חובה ', $message ) ) {

			wp_send_json( $response );
		}
	}
}

add_action( 'wp_ajax_sogo_send_order_data', 'sogo_send_order_data' );
add_action( 'wp_ajax_nopriv_sogo_send_order_data', 'sogo_send_order_data' );

/**
 * Update insurance params in options DB
 */
function sogo_update_insurance_params() {
	session_start();
	$link_page     = $_POST['link_page'];
	$ins_order     = $_POST['ins_order'];
	$ins_company   = $_POST['ins_company'];
	$company_id    = $_POST['company_id'];
	$price_havila  = $_POST['package'];
	$addInfo       = $_POST['add_info'];
	$mandat_price  = null;
	$second_price  = null;
	$insuranseType = $_SESSION['ins_orders'][ $ins_order ]['ins_type'];


	$avaliable_companies = json_decode( $_SESSION['avaliableCompanies'], true );


	if ( preg_match( '/,/', $company_id ) ) {
		//0 = id of mandatory company
		//1 = id of third party company
		$id_mandatory_company   = explode( ',', $company_id )[0];
		$id_third_party_company = explode( ',', $company_id )[1];

		foreach ( $avaliable_companies as $avaliable_company ) {

			if ( ( (int) $id_mandatory_company === (int) $avaliable_company['mandatory_company_id'] ) && ( (int) $id_third_party_company === (int) $avaliable_company['company_id'] ) ) {

				if ( isset( $avaliable_company['mandat_price'] ) && ! empty( $avaliable_company['mandat_price'] ) ) {
					$mandat_price = $avaliable_company['mandat_price'];
				} else if ( isset( $avaliable_company['mandatory'] ) && ! empty( $avaliable_company['mandatory'] ) ) {
					$mandat_price = $avaliable_company['mandatory'];
				} else {
					$mandat_price = $avaliable_company['price'];
				}

			}

			if ( (int) $id_third_party_company === (int) $avaliable_company['company_id'] && isset( $avaliable_company['comprehensive_normal'] ) ) {

				$second_price = $avaliable_company['comprehensive_normal'];
			}

		}


	} else {

		foreach ( $avaliable_companies as $avaliable_company ) {


			if ( $company_id == $avaliable_company['company_id'] && ! isset( $avaliable_company['comprehensive_normal'] ) ) {

				if ( isset( $avaliable_company['mandat_price'] ) && ! empty( $avaliable_company['mandat_price'] ) ) {
					$mandat_price = $avaliable_company['mandat_price'];
				} else if ( isset( $avaliable_company['mandatory'] ) && ! empty( $avaliable_company['mandatory'] ) ) {
					$mandat_price = $avaliable_company['mandatory'];
				} else {
					$mandat_price = $avaliable_company['price'];
				}


				if ( isset( $avaliable_company['comprehensive'] ) && ! is_null( $avaliable_company['comprehensive'] ) && ! empty( $avaliable_company['comprehensive'] ) ) {
					$second_price = $avaliable_company['comprehensive'];
				}

			}
		}

	}

	$ins_options                                  = get_option( 'insurance-order_' . $ins_order );
	$ins_options['order_details']['ins_order']    = $ins_order;
	$ins_options['order_details']['ins_company']  = $ins_company;
	$ins_options['order_details']['price_havila'] = $price_havila;
	$ins_options['order_details']['company_id']   = $company_id;
	$ins_options['order_details']['add_info']     = $addInfo;
	//$ins_options['company_slug'] = $company_slug;
	$ins_options['order_details']['mandat_price'] = trim( $mandat_price );
	$ins_options['order_details']['second_price'] = trim( $second_price );

	//override prices of the old chosen order to new chosen order
	if ( isset( $_SESSION['ins_orders'][ $ins_order ]['params'] ) ) {

		$_SESSION['ins_orders'][ $ins_order ]['params'] = $ins_options;
		//$_SESSION['ins_orders'][$ins_order]['params']['order_details']['mandat_price'] = trim( $mandat_price );
		//$_SESSION['ins_orders'][$ins_order]['params']['order_details']['second_price'] = trim( $second_price );
		//$ins_options['order_details']['price_havila']

	}

	//mail('victor@sogo.co.il', 'order info after click to by insurance button', var_export($ins_options, true));
	delete_option( 'insurance-order_' . $ins_order );
	update_option( 'insurance-order_' . $ins_order, $ins_options );

	wp_send_json( array( 'link' => $link_page . '?ins_order=' . $ins_order . '&i_type=' . $insuranseType ) );

}

add_action( 'wp_ajax_sogo_update_insurance_params', 'sogo_update_insurance_params' );
add_action( 'wp_ajax_nopriv_sogo_update_insurance_params', 'sogo_update_insurance_params' );

function sogo_set_translate_name( $name, $value = false ) {

	switch ( $name ) {
		case 'ins-order':
			return [ 'מספר הזמנה', $value ];
			break;
		case 'license-number':
			return array( 'מס רישוי', $value );
			break;
		case 'ownership-date':
			$value = $value == 1 ? 'פחות משנה' : 'מעל שנה';

			return array( 'ממתי הרכב בבעלותך', $value );
			break;
		case 'ownership-under-year':
			return array( 'הרכב בבעלותי', $value );
		case 'first-name':
			return array( 'שם פרטי', $value );
		case  'last-name':
			return array( 'שם משפחה', $value );
		case  'identical-number':
			return array( 'מס זהות', $value );
		case  'birthday-date':
			return array( 'ת.לידה', $value );
		case  'gender':
			$value = $value == 1 ? 'זכר' : 'נקבה';

			return array( 'מין', $value );
		case  'drive-allowed':
			$newValue = $value == 1 ? 'כן' : 'לא';

			return array( 'האם בעל הפוליסה הינו אחד הנהגים ברכב ?', $newValue );
		case  'license-year':
			return array( 'שנת הוצאת רשיון', $value );
		case  'mobile-phone-number':
			return array( 'טלפון נייד', $value );
		case  'email':
			return array( 'דוא"ל', $value );
		case  'additional-phone-number':
			return array( 'טלפון נוסף', $value );
		case  'city':
			return array( 'עיר מגורים', $value );
		case  'street':
			return array( 'רחוב', $value );
		case  'house-number':
			return array( 'מס בית', $value );
		case  'apartment-number':
			return array( 'דירה', $value );
		case  'use-another-address':
			$newValue = $value == 'on' ? 'כן' : 'לא';

			return array( 'כתובת למשלוח שונה', $newValue );
		case  'city-another':
			return array( 'עיר למשלוח', $value );
		case  'street-another':
			return array( 'רחוב למשלוח', $value );
		case  'house-number-another':
			return array( 'מס בית למשלוח', $value );
		case  'apartment-number-another':
			return array( 'דירה למשלוח', $value );
		case  'driver-first-name':
			return array( 'שם פרטי של הנהג', $value );
		case  'driver-last-name':
			return array( 'שם משפחה של הנהג', $value );
		case  'driver-identical-number':
			return array( 'ת.ז של הנהג', $value );
		case  'driver-birthday':
			return array( 'ת.לידה של הנהג', $value );
		case  'driver-gender':
			$newValue = $value == 1 ? 'זכר' : 'נקבה';

			return array( 'מין של הנהג', $newValue );
		case  'years-issuing-license':
			return array( 'שנת קבלת רשיון', $value );
		case  'use-phone-payment':
			$value = $value == 'on' ? 'כן' : 'לא';

			return array( 'תשלום טלפוני דרך נציג', $value );
		case  'cardholder-name':
			return array( 'שם בעל הכרטיס', $value );
		case  'cardholder-id':
			return array( 'ת.ז של בעל הכרטיס', $value );
		case  'card-number':
			return array( 'מס\' אשראי', $value );
		case  'card-month':
			return array( 'תוקף - חודש', $value );
		case  'card-year':
			return array( 'תוקף - שנה', $value );
		case  'cvv-number':
			return array( '3 ספרות', $value );
		case  'mandat-num-payments':
			return array( 'תשלומים חובה', $value );
		case  'other-num-payments':
			return array( 'תשלומים מקיף/צד ג', $value );
		case 'havila-num-payments':
			return [ 'תשלומים חבילה', $value ];
		case 'upsales-number-payments':
			return [ 'תשלומים אפסיילס', $value ];
		case  'ins-company':
			return array( 'שם חברת ביטוח', $value );
		case  'mandat-price':
			return array( 'סכום חובה', $value );
		case  'second-price':
			return array( 'סכום מקיף/צד ג', $value );
		case 'package-price':
			return [ 'סכום חבילה', $value ];
		case 'upsales-price':
			return [ 'סכום אפסיילס', $value ];

	}
}


/**
 * Autocomplete for city
 */
function sogo_get_cities() {
	global $wpdb;

	$city = $_POST['search'];

	$query = "SELECT zip_code, city FROM wp_cities WHERE city like'" . $city . "%'";

	$result = $wpdb->get_results( $query, ARRAY_A );

	wp_send_json( $result );
}

add_action( 'wp_ajax_sogo_get_cities', 'sogo_get_cities' );
add_action( 'wp_ajax_nopriv_sogo_get_cities', 'sogo_get_cities' );


function sogo_get_city_code($city_name, $col = 'city_code') {
	global $wpdb;
	$query = "SELECT $col FROM wp_cities WHERE city ='" . $city_name . "'";
	return $wpdb->get_var( $query );

}


function get_insurance_type_from_url() {

	$type = '';

	switch ( $_GET['insurance-type'] ) {

		case '':
			$type = 'חובה';
			break;
		case 'ZAD_G':
			$type = 'חובה וצד ג';
			break;
		case 'MAKIF':
			$type = 'חובה ומקיף';
			break;
	}

	return $type;
}

function sogo_include_tooltip( $key, $help_array, $tip_title, $tip_content ) {
	include 'templates/tooltip.php';
}


/**
 *  logo shortcode
 */
function sogo_print_logo( $atts ) {
	$a = shortcode_atts( array(
		'link_class'  => '',
		'image_class' => ''
	), $atts );
	ob_start();
	?>
    <a href="<?php echo get_home_url(); ?>" class="d-inline-block mb-lg-2 <?php echo $a['link_class'] ?>">
        <img src="<?php echo get_stylesheet_directory_uri() . '/images/logohovawhite.png'; ?> " alt="logo"
             class="<?php echo $a['image_class'] ?>">
    </a>
	<?php
	return ob_get_clean();
}

add_shortcode( 'sogo_logo', 'sogo_print_logo' );


/**
 *  phone shortcode
 */
function sogo_print_phone( $atts ) {
	$a = shortcode_atts( array(
		'link_class'  => '',
		'icon_class'  => '',
		'phone_class' => ''
	), $atts );
	ob_start();
	?>
    <a target="_blank" class="<?php echo $a['link_class']; ?>"
       href="tel:<?php echo esc_attr( get_field( '_sogo_phone', 'option' ) ); ?>" title="phone number">
        <span class="<?php echo $a['icon_class']; ?>"></span>
        <span class="<?php echo $a['phone_class']; ?>"><?php echo get_field( '_sogo_footer_phone_text', 'option' ); ?></span>
    </a>
	<?php
	return ob_get_clean();
}

add_shortcode( 'sogo_phone', 'sogo_print_phone' );


/**
 * social shortcode
 */
function sogo_print_social( $atts ) {
	$a = shortcode_atts( array(
		'ul_class'   => '',
		'li_class'   => '',
		'link_class' => '',
		'icon_class' => ''
	), $atts );
	ob_start();
	?>
    <ul class="row flex-wrap <?php echo $a['ul_class']; ?>">
		<?php while ( have_rows( '_sogo_social', 'option' ) ) : the_row();
			$link = get_sub_field( 'link' );
			$icon = get_sub_field( 'icon' );
			$text = get_sub_field( 'text' );
			?>
            <li class="col-auto px-15 <?php echo $a['li_class']; ?>">
                <a target="_blank" class="<?php echo $a['link_class']; ?>" href="<?php echo $link; ?>"
                   title="<?php echo $text; ?>"
                   aria-label="<?php _e( 'Social', 'sogoc' ) ?>">
                    <span class="<?php echo $icon . ' ' . $a['icon_class']; ?>"></span>
                </a>
            </li>
		<?php endwhile; ?>
    </ul>
	<?php
	return ob_get_clean();
}

add_shortcode( 'sogo_social', 'sogo_print_social' );


/**
 * facebook page shortcode
 */
function sogo_print_facebook_page( $atts ) {
	$a = shortcode_atts( array(
		'width' => '500'
	), $atts );
	ob_start();
	?>
    <div class="fb-page text-center"
         data-href="<?php echo get_field( '_sogo_facebook_link', 'option' ); ?>"
         data-hide-cover="false"
         data-show-facepile="true"
         data-width="<?php echo $a['width']; ?>">
    </div>
	<?php
	return ob_get_clean();
}

add_shortcode( 'sogo_facebook_page', 'sogo_print_facebook_page' );


/**
 * facebook link
 */
function sogo_print_facebook() {
	ob_start();
	?>
    <a href="<?php echo esc_url( get_field( '_sogo_facebook_link', 'option' ) ); ?>" title="go to our facebook page">
        <span class="icon-facebook-01 d-inline-block icon-xs color-white align-middle"></span>
        <span class="align-middle text-p color-white hover-1 transition"><?php echo __( 'Visit us on facebook', 'sogoc' ); ?></span>
    </a>
	<?php
	return ob_get_clean();
}

add_shortcode( 'sogo_facebook', 'sogo_print_facebook' );


// Function to change email address

function wpb_sender_email( $original_email_address ) {
	return 'sales@hova.co.il';
}

// Function to change sender name
function wpb_sender_name( $original_email_from ) {
	return 'הודעה מאתר hova.co.il';
}

// Hooking up our functions to WordPress filters
add_filter( 'wp_mail_from', 'wpb_sender_email' );
add_filter( 'wp_mail_from_name', 'wpb_sender_name' );

//Get relevant sidebar according to to insurance type
function get_sidebars_by_insurance_type( $ins_type ) {
	//Insurance type
	$left_sidebar = $bottom_sidebar = '';
	$type         = trim( strip_tags( $ins_type ) );

	switch ( $type ) {
		case 1:
			$left_sidebar   = 'left_sidebar';
			$bottom_sidebar = 'bottom_sidebar';
			break;
		case 2:
			$left_sidebar   = 'left_sidebar_mekif';
			$bottom_sidebar = 'bottom_sidebar_mekif';
			break;
		case 3:
			$left_sidebar   = 'left_sidebar_zad3';
			$bottom_sidebar = 'bottom_sidebar_zad3';
			break;
	}

	return [ $left_sidebar, $bottom_sidebar ];

}

//Get car details by code levi
function sogo_get_car_details_by_code_levi() {
	global $wpdb;

	$code_levi = trim( strip_tags( $_POST['code_levi'] ) );
	$car_year  = trim( strip_tags( $_POST['car_year'] ) );

	if ( ! $code_levi ) {
		wp_send_json( [ 'message' => 'error', 'data' => [] ] );
		exit();
	}

	$sql    = "SELECT * FROM wp_car_models WHERE `code_levi` = {$code_levi} AND `year`= '{$car_year}'";
	$result = $wpdb->get_results( $sql, OBJECT );

	if ( $result ) {

		wp_send_json( [ 'message' => 'success', 'data' => $result ] );
		exit();
	}

}

add_action( 'wp_ajax_sogo_get_car_details_by_code_levi', 'sogo_get_car_details_by_code_levi' );
add_action( 'wp_ajax_nopriv_sogo_get_car_details_by_code_levi', 'sogo_get_car_details_by_code_levi' );

function myprefix_redirect_attachment_page() {
	if ( is_attachment() ) {
		global $post;
		if ( $post && $post->post_parent ) {
			wp_redirect( esc_url( get_permalink( $post->post_parent ) ), 301 );
			exit;
		} else {
			wp_redirect( esc_url( home_url( '/' ) ), 301 );
			exit;
		}
	}
}

add_action( 'template_redirect', 'myprefix_redirect_attachment_page' );


function sogo_set_session( $insuranseId ) {

	$order_params = [];//handle existing order params if exists or empty array


//Getting current ins_order and his data id exists in db

//if came from any source except Home page/
	if ( ( is_null( $_SESSION['tmp_ins_order'] ) || ! isset( $_SESSION['tmp_ins_order'] ) ) && ! isset( $_GET['ins_order'] ) ) {

		$ins_order                                        = uniqid();
		$_SESSION['ins_orders'][ $ins_order ]['id']       = $ins_order;
		$_SESSION['ins_orders'][ $ins_order ]['ins_type'] = $insuranseId;
		$_SESSION['tmp_ins_order']                        = $ins_order;

	} else if ( isset( $_GET['ins_order'] ) && ! empty( $_GET['ins_order'] ) ) {

		$ins_order                                        = trim( strip_tags( $_GET['ins_order'] ) );
		$_SESSION['ins_orders'][ $ins_order ]['id']       = $ins_order;
		$_SESSION['ins_orders'][ $ins_order ]['ins_type'] = $insuranseId;
	} else {

		if ( is_null( $_SESSION['ins_orders'][ $_SESSION['tmp_ins_order'] ]['id'] ) ) {
			$_SESSION['ins_orders'][ $_SESSION['tmp_ins_order'] ]['id'] = trim( strip_tags( $_SESSION['tmp_ins_order'] ) );
		}

		$ins_order                                        = $_SESSION['ins_orders'][ $_SESSION['tmp_ins_order'] ]['id'];
		$_SESSION['ins_orders'][ $ins_order ]['ins_type'] = $insuranseId;
	}

	$order_params = get_option( 'insurance-order_' . $ins_order );

//condition to handle existing order parameters for auto fill second form
	if ( $order_params !== false ) {
		$_SESSION['ins_orders'][ $ins_order ]['params'] = $order_params;
	}


}


/**
 *  AJAX function for getting apartment insurance prices
 */

function sogo_get_dira() {
	 
	$params = json_decode( stripslashes( $_POST['order_data'] ) );


	$health = new ozar_dira();
 
//	$health->calc( array(
//
//		'CoverageGroup'   => 80100002,
//		'InsuranceDate'   => "1970-01-01T00:00:00.000Z",
//		'MAGE'            => null,
//		'MAGE_PARAMETER' => null,
//		'MAIM'            => 80600001,
//		'MASHKANTA'       => null,
//		'MSUM'           => null,
//		'MTVIA'           => null,
//		'MTYPE'           => 80500001,
//		'MTYPE_PARAMETER' => null,
//		'TSUM'            => 111111,
//		'TTVIA'           => 80700001,
//		'TTYPE'           => null,
//		'TTYPE_PARAMETER' => null,
//
//
//
//	) );
	$health->calc( array(

		'CoverageGroup'   => (int)$params->coverage,
		'InsuranceDate'   => "1970-01-01T00:00:00.000Z",
		'MAGE'            => null,
		'MAGE_PARAMETER'  => $params->mage_parameter,
		'MAIM'            => $params->maim,
		'MASHKANTA'       => $params->mashkanta,
		'MSUM'            => $params->msum,
		'MTVIA'           => $params->mtvia,
		'MTYPE'           => (int)$params->mtype,
		'MTYPE_PARAMETER' => $params->mtype_parameter,
		'TSUM'            => $params->tsum,
		'TTVIA'           => (int)$params->ttvia,
		'TTYPE'           => null,//$params->mtype,
		'TTYPE_PARAMETER' => $params->mtype_parameter,




	) );
//	$health->connect();

 	wp_send_json_success( $health->connect() );
}

add_action( 'wp_ajax_nopriv_sogo_get_dira', 'sogo_get_dira' );
add_action( 'wp_ajax_sogo_get_dira', 'sogo_get_dira' );


function sogo_get_dira_params() {
	$health = new ozar_dira();
	wp_send_json_success( $health->get_params() );
}

add_action( 'wp_ajax_nopriv_sogo_get_dira_params', 'sogo_get_dira_params' );
add_action( 'wp_ajax_sogo_get_dira_params', 'sogo_get_dira_params' );
