<?php
//ini_set('display_errors', 1);
//error_reporting(E_ALL);



session_start();

/*
 * setting up session to avoid wrong $in_order number when pressing back button in browser
 */

//$_POST['insurance-date-finish'] = array_key_exists('insurance-date-finish', $_POST) ? trim($_POST['insurance-date-finish']) : date('Y-m-d');
$_POST['insurance-date-finish'] = isset( $_POST['insurance-date-finish'] ) ? trim( $_POST['insurance-date-finish'] ) : date( 'Y-m-d' );

if ( isset( $_POST['insurance-date-start'] ) && ! empty( $_POST['insurance-date-start'] ) ) {
	$_POST['insurance-date-start'] = trim( $_POST['insurance_period'] );
}

$ins_order    = trim(strip_tags($_GET['ins_order']));
$total_array  = array();

//if not exists sessions array with current insurance order we create new session
if (is_null($_SESSION['ins_orders'][$ins_order]['id'])) {
	$_SESSION['ins_orders'][$ins_order]['id'] = $ins_order;
}



$order_params = get_ins_order( $_SESSION['ins_orders'][$ins_order]['id']);//get_option( 'insurance-order_' . $_SESSION['ins_orders'][$ins_order]['id']);

//redirect with no ins_order param or wrong ins_order to the homepage
if (!$order_params || ! isset( $_GET['ins_order'] ) || empty( $_GET['ins_order'] ) || isset($_COOKIE['done'])) {
	header( 'Location: http://' . $_SERVER['HTTP_HOST'] );
	exit();
}
//var_dump($_POST); die;


$o_params                            = array_merge( $_POST, $order_params );

$o_params['order_info']['levi-code'] = sogo_get_levi_code( $o_params );

if ( ! isset( $_SESSION['insurance_results'] ) ) {
	$_SESSION['insurance_results'] = $ins_order;
}

// Template Name: page insurance compare 2
if ( isset( $_GET['iframe'] ) && $_GET['iframe'] == '1' ) {
	get_header( 'iframe' );
} else {
	get_header();
}

the_post();
require_once dirname( __FILE__ ) . '/insurance-api/ayalon/lib/ayalonws.php';
require_once dirname( __FILE__ ) . '/insurance-api/shirbit/lib/shirbitws.php';
require_once dirname( __FILE__ ) . '/insurance-api/hachshara/lib/hachsharaws.php';
require_once dirname( __FILE__ ) . '/insurance-api/menora/lib/menoraws.php';
require_once dirname( __FILE__ ) . '/insurance-api/shlomo/lib/shlomows.php';
require_once dirname( __FILE__ ) . '/insurance-api/otzar/ozar_hova.php';
require_once dirname( __FILE__ ) . '/insurance-api/restart/lib/restartws.php';
require_once dirname( __FILE__ ) . '/insurance-api/clal/lib/clalws.php';
require_once dirname( __FILE__ ) . '/insurance-api/go/lib/gows.php';
require_once dirname( __FILE__ ) . '/insurance-api/shomera/lib/shomera.php';
include "lib/SogoInsurance.php";



if (isset($_GET['dev']) && (int)$_GET['dev'] === 1) {
//	echo '<pre style="direction: ltr;">';
//	var_dump($o_params);
//	echo '</pre>';
}
//var_dump($o_params['order_details']);die;
$insurances = new SogoInsurance( $o_params['order_details'] );
//var_dump($o_params['order_details']);die;
$companies  = $insurances->get_insurance_companies();
$in_type_by_name =  trim(strip_tags($_GET['insurance-type']));
//var_dump($insurances);die;
$in_type         =  null;
$in_type         = $_SESSION['in_type'] = $_SESSION['ins_orders'][$ins_order]['ins_type'];
if(!$in_type){
    $in_type =$_SESSION['in_type'] = (int)$order_params['order_details']['in_type'] ;
}

if (
(((int)$order_params['order_details']["body-claims"] !== 3) && // more than 2 body claims // insuranse type not mandatory
    (int)$order_params['order_details']["law-suites-3-year"] < 3 &&// more than 2 property claims
	$order_params['order_details']["criminal-record"] != '1' && // don't have criminal record
	$order_params['order_details']["license-suspensions"] <= '1'  // don't have more than 1 license suspension
) || ((int)$_SESSION['ins_orders'][$ins_order]['ins_type'] === 1 &&
       ((int)$order_params['order_details']["law-suites-3-year"] < 3
        && (int)$order_params['order_details']["body-claims"] < 2
        && (int)$order_params['order_details']["license-suspensions"] < 2))) {
    //var_dump($insurances);die; //"engine_capacity" -> ok
    $total_arrayTmp = ( in_array( $_GET['insurance-type'], $insurances->ins_type_Arr ) ? $insurances->get_insurance_api_results() : $insurances->get_hova() );
    //var_dump($total_arrayTmp);die;
//    var_dump($insurances);die; //"engine_capacity" -> not

    //if is third party insurance we add combine insurance companies with lowest prices options
    if ($in_type === 3 && !empty($insurances->get_arr_hova_for_mix())) {

	    $tmp_min_price_hova_for_mix  = min($insurances->get_arr_hova_for_mix());
	    $tmp_arr_zad_g_for_mix = $insurances->get_arr_zad_g_for_mix();
	//    var_dump($tmp_min_price_hova_for_mix);
	    $total_mix_array = sogo_mix_by_lowest_price($tmp_arr_zad_g_for_mix, $tmp_min_price_hova_for_mix);

	    $total_arrayTmp = array_merge($total_arrayTmp, $total_mix_array);
	   // $_SESSION['ins_orders'][$ins_order]['hova'] = $tmp_min_price_hova_for_mix;
    }

	//$total_array  =   $total_mix_array;

	$total_array     = sogo_sort_by_total_price( $total_arrayTmp ,$in_type !== 1);

    //if insurance is mandatory only, we change the name of companies from ,misrad haosar.
    if ((int)$_SESSION['ins_orders'][$ins_order]['ins_type'] === 1) {
	    foreach ($total_array as $arrKey => &$arrVal) {
//		    echo '<pre style="direction: ltr;">';
//		    var_dump($arrVal);
//		    echo '</pre>';
		    if ((int)$arrVal['company_id'] === (int)$companies[$arrVal['company_id']]['company_id']) {
			    $arrVal['company'] = $companies[$arrVal['company_id']]['company_name'];
		    }
	    }
    }
//	echo '<pre style="direction: ltr;">';
//	var_dump($total_array);
//	echo '</pre>';


} else {
	?>
    <script>
        jQuery(document).ready(function( $ ) {
            setTimeout(function () {
                    $('html, body').animate({
                        scrollTop: $('.contact-us-by-phone').offset().top - 150
                    }, 1000);
                }, 1500)
            });
    </script>
	<?php
}

//collecting companies with prices to session
$_SESSION['avaliableCompanies'] = [];
$_SESSION['avaliableCompanies'] = json_encode( $total_array );

$title = "";




//chosen insurance compare order link that be send if customer chose contact me by phone
$contactUsOrderLink = null;

switch ( $in_type_by_name ) {
	case 'HOVA':
		$title = get_field( '_sogo_cmpare_page_hova' );
		//$in_type =  1;
		//	$_SESSION['in_type'] = 1;
		break;
	case 'MAKIF':
		$title = get_field( '_sogo_cmpare_page_mekif' );
		//$in_type =  2;
		//	$_SESSION['in_type'] = 2;
		break;
	case 'ZAD_G':
		$title = get_field( '_sogo_cmpare_page_zadg' );
		//	$in_type =  3;
		//	$_SESSION['in_type'] = 3;
		break;
	default:
		$title = '';
}


//link for contact form of chosen order
$homePageId         = get_option('page_on_front');
$contactUsOrderLink = get_field( '_sogo_main_section_1_button_' . $in_type . '_link', $homePageId);

?>
    <div class="page-insurance-compare-2 pb-5">

        <section class="section-insurance-compare-2">

            <!-- CONTAINER-FLUID -->
            <div class="container-fluid">

                <!-- ROW TITLE-->
                <div class="row justify-content-center mb-3">

                    <div class="col-lg-8">


                        <h1 class="text-1 color-4 mt-3"><?php echo $title; ?></h1>

                    </div>

                </div>


                <!-- ROW -->
                <div class="row justify-content-center">

                    <div class="col-lg-10 px-0 px-lg-2  col-xl-7">

						<?php if ( ! wp_is_mobile() ): ?>

                            <!-- ROW -->
                            <div class="row text-center mb-3">

                                <!-- TIME LINE -->
                                <div class="col-lg-12 d-flex justify-content-between">

                                    <div class="time-line d-flex flex-column align-items-center justify-content-center time-line-finish">

                                        <span class="time-number">1</span>

                                        <span class="time-text">פרטים אישיים</span>

                                    </div>

                                    <div class="time-line d-flex flex-column align-items-center justify-content-center time-side-bars time-line-blue time-line-current">

                                        <span class="time-number">2</span>

                                        <span class="time-text">תוצאות חיפוש</span>

                                    </div>

                                    <div class="time-line d-flex flex-column align-items-center justify-content-center">

                                        <span class="time-number">3</span>

                                        <span class="time-text">הזמנת פוליסה</span>

                                    </div>

                                </div>

                            </div>


                        <!-- ROW -->
                        <div class="row mb-5">

                            <!-- INSURANCES TITLE -->
                            <div class="col-lg-12 h2">

								<?php the_content(); ?>

                            </div>

                            <!-- important to know -->
                            <div class="col-lg-12 mb-2">

                                <p class="text-p color-6 normal">
                                    <span class="medium color-4"><?php _e( 'Important to know', 'sogoc' ); ?>:</span>
									<?php the_field( '_sogo_page_insurance_compare_2_important' ); ?>
                                </p>

                            </div>

                            <!-- logos galery -->
                            <div class="col-lg-12 mb-lg-4 mb-2">

                                <div class="js-insurance-logos-slider bg-white p-2 b-radius-2 border border-color-7 border-width-x1">
									<?php
									$logos = get_field( '_sogo_page_insurance_compare_2_logos' );
									foreach ( $logos as $logo ):
										?>

                                        <div class="mx-1">
                                            <img src="<?php echo $logo['sizes']['company-logo']; ?>"
                                                 alt="<?php $logo['alt']; ?>"
                                                 class="mx-auto img-fluid">
                                        </div>

									<?php endforeach; ?>
                                </div>

                            </div>

	                        <?php endif; ?>

                            <!-- total text -->
                            <div class="col-lg-12 mb-2">

                                <div class="text-4 color-4 normal">
									<?php
									$cube_empties_total = 0;
									$first_cube         = false;
									$first_cube_count   = false;

									foreach ( $total_array as $item ): ?>

										<?php if ( isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'MAKIF' || $_GET['insurance-type'] == 'ZAD_G' ) ): ?>

											<?php if ( ( ! $item['mandatory'] || ! $item['comprehensive'] ) ): ?>
												<?php $cube_empties_total ++; ?>
											<?php endif; ?>

										<?php else: ?>

											<?php if ( is_null( $item['price'] ) ): ?>

												<?php $cube_empties_total ++; ?>

											<?php endif; ?>

										<?php endif; ?>
									<?php endforeach;

									echo sprintf( __( 'Total', 'sogoc' ) . ' %s ' . __( 'suggestion for car insurance', 'sogoc' ) . ' - ' . '%s ' . __( 'for', 'sogoc' ) . '%s %s %s %s',
										count( $total_array ) - $cube_empties_total,
										get_insurance_type_from_url(),
										stripslashes($order_params['order_details']['vehicle-manufacturer']),
										stripslashes($order_params['order_details']['vehicle-brand']),
										__( 'for year', 'sogoc' ),
										$order_params['order_details']['vehicle-year'] ); ?>

                                    <!--									--><?php //debug( $total_array ); ?>

                                </div>

                            </div>
                            <!-- insurance period text -->
                            <div class="col-lg-12 mb-3">

                                <p class="text-p color-6 normal mb-1">
									<?php echo sprintf( '%s %s %s %s',
										__( 'insurance period', 'sogoc' ),
										$order_params['order_details']['insurance-date-start'],
										__( 'until', 'sogoc' ),
										$order_params['order_details']['insurance-date-finish'] ); ?>
                                </p>

                                <p class="text-p color-6 normal">
									<?php the_field( '_sogo_page_insurance_compare_2_bottom_text' ); ?>
                                </p>

                            </div>
                            <!-- sami - add more options to compare -->
<?php
	include 'templates/insurance-compare/sami-recompare-button.php';
?>
							<?php $cube_index = 1; ?>
							<?php $cube_empties = 0; ?>

							<?php if ( empty( $total_array ) ): ?>
                                                                <div style="border: 1px solid #ffffff; border-top-right-radius: 25px; border-top-left-radius: 25px" class="col-lg-12 pt-3 mx-0 mx-lg-1 bg-white insurance-cube-wrapper mb-3 mt-1">
                                    <div class="text-2 color-4 text-center">הרובוט שלנו לא מצא הצעות</div>
                                    <div class="text-4 color-3 text-center">זה הזמן שלנו להוכיח שהאדם חכם מהרובוט</div>
                                    <div class="text-4 color-3 mb-2 text-center">השאירו פרטים ונחזור עם הצעה מנצחת :)</div>
									<div class="text-center">
<svg xmlns="http://www.w3.org/2000/svg" width="150" height="125">
  <defs>
    <clipPath id="c_1">
      <path id="svg_1" d="M0 0h1100v825H0V0z"/>
    </clipPath>
    <clipPath id="c0">
      <path id="svg_2" d="M-4 823V-2h1100v825H-4z"/>
    </clipPath>
    <style>
      .g0{fill:#fff}.g1{fill:#00b0f0}.g2{fill:none;stroke:#0070c0;stroke-width:6.885;stroke-linecap:butt;stroke-linejoin:round}.g4{fill:#ffc000}
    </style>
  </defs>
  <path fill="none" id="canvas_background" d="M-1-1h152v127H-1z"/>
  <g>
    <g id="svg_4" clip-path="url(#c_1)">
      <path id="svg_7" class="g1" d="M143.9 67.6V84l-.1.4v.3l-.1.3-.1.3-.1.4-.1.3-.1.3-.1.3-.2.3-.2.3-.2.2-.2.3-.2.2-.3.3-.2.2-.2.2-.3.3-.3.2-.3.1-.3.2-.3.2-.3.1-.3.1-.3.1-.4.1h-.3l-.3.1h-.7l-6.5.1V61.1h6.8l.3.1h.4l.3.1.3.1h.3l.3.1.3.2.3.1.3.1.3.2.2.2.3.2.3.2.2.2.2.2.2.3.3.2.2.3.2.3.1.2.2.3.1.3.1.3.1.3.1.3.1.4.1.3v.3l.1.3v.4z" fill-rule="evenodd"/>
      <path id="svg_8" class="g2" d="M143.9 67.6V84l-.1.4v.3l-.1.3-.1.3-.1.4-.1.3-.1.3-.1.3-.2.3-.2.3-.2.2-.2.3-.2.2-.3.3-.2.2-.2.2-.3.3-.3.2-.3.1-.3.2-.3.2-.3.1-.3.1-.3.1-.4.1h-.3l-.3.1h-.7l-6.5.1V61.1h6.8l.3.1h.4l.3.1.3.1h.3l.3.1.3.2.3.1.3.1.3.2.2.2.3.2.3.2.2.2.2.2.2.3.3.2.2.3.2.3.1.2.2.3.1.3.1.3.1.3.1.3.1.4.1.3v.3l.1.3v.4z"/>
      <path id="svg_9" class="g1" d="M6.4 83.7v-17l.1-.4.1-.3.1-.3.1-.3.1-.3.1-.3.2-.3.2-.3.2-.3.2-.2.2-.3.3-.3.2-.2.2-.2.3-.2.3-.2.3-.2.3-.1.3-.2.3-.1.3-.1.3-.2h.4l.3-.1h.3l.4-.1h6.8v29h-7.1l-.3-.1h-.4l-.3-.1-.3-.1-.3-.1-.3-.1-.3-.1-.3-.2-.3-.2-.2-.1-.3-.2-.3-.3-.2-.2-.2-.2-.2-.3-.3-.2-.2-.2-.2-.3-.1-.3-.2-.3-.1-.3-.1-.3-.1-.3-.1-.3-.1-.4-.1-.3v-1z" fill-rule="evenodd"/>
      <path id="svg_10" class="g2" d="M6.4 83.7v-17l.1-.4.1-.3.1-.3.1-.3.1-.3.1-.3.2-.3.2-.3.2-.3.2-.2.2-.3.3-.3.2-.2.2-.2.3-.2.3-.2.3-.2.3-.1.3-.2.3-.1.3-.1.3-.2h.4l.3-.1h.3l.4-.1h6.8v29h-7.1l-.3-.1h-.4l-.3-.1-.3-.1-.3-.1-.3-.1-.3-.1-.3-.2-.3-.2-.2-.1-.3-.2-.3-.3-.2-.2-.2-.2-.2-.3-.3-.2-.2-.2-.2-.3-.1-.3-.2-.3-.1-.3-.1-.3-.1-.3-.1-.3-.1-.4-.1-.3v-1z"/>
      <path id="svg_11" d="M19.3 58.6l.1-1v-1l.2-1 .2-1 .2-1 .3-.9.3-1 .4-.9.4-.9.5-.9.5-.8.6-.8.6-.9.6-.7.7-.7.8-.7.7-.7.8-.6.8-.5.9-.6.9-.4.9-.5.9-.4 1-.3.9-.3 1-.2 1-.2.9-.1 1-.1h76.4l1 .1 1 .1 1 .2.9.2 1 .3.9.3 1 .4.9.5.9.4.8.6.8.5.8.6.8.7.7.7.7.7.7.7.6.9.5.8.5.9.5.8.5.9.3.9.3 1 .3.9.3 1 .2 1 .1 1 .1 1v42.7l-.2 1-.2 1-.2.9-.3 1-.3.9-.4 1-.4.9-.5.8-.5.9-.6.8-.6.8-.7.8-.6.7-.8.7-.7.7-.8.6-.9.5-.8.5-.9.5-.9.5-.9.3-1 .3-.9.3-1 .3-1 .2-1 .1-1 .1H36.4l-.9-.2-1-.2-1-.2-.9-.3-1-.3-.9-.4-.9-.4-.9-.5-.9-.5-.8-.6-.8-.6-.7-.7-.8-.6-.7-.8-.6-.7-.6-.8-.6-.9-.5-.8-.5-.9-.4-.9-.4-.9-.3-1-.3-.9-.2-1-.2-1-.2-1v-1l-.1-1V58.6z" fill-rule="evenodd" fill="#f2f2f2"/>
      <path id="svg_12" class="g2" d="M19.3 58.6l.1-1v-1l.2-1 .2-1 .2-1 .3-.9.3-1 .4-.9.4-.9.5-.9.5-.8.6-.8.6-.9.6-.7.7-.7.8-.7.7-.7.8-.6.8-.5.9-.6.9-.4.9-.5.9-.4 1-.3.9-.3 1-.2 1-.2.9-.1 1-.1h76.4l1 .1 1 .1 1 .2.9.2 1 .3.9.3 1 .4.9.5.9.4.8.6.8.5.8.6.8.7.7.7.7.7.7.7.6.9.5.8.5.9.5.8.5.9.3.9.3 1 .3.9.3 1 .2 1 .1 1 .1 1v42.7l-.2 1-.2 1-.2.9-.3 1-.3.9-.4 1-.4.9-.5.8-.5.9-.6.8-.6.8-.7.8-.6.7-.8.7-.7.7-.8.6-.9.5-.8.5-.9.5-.9.5-.9.3-1 .3-.9.3-1 .3-1 .2-1 .1-1 .1H36.4l-.9-.2-1-.2-1-.2-.9-.3-1-.3-.9-.4-.9-.4-.9-.5-.9-.5-.8-.6-.8-.6-.7-.7-.8-.6-.7-.8-.6-.7-.6-.8-.6-.9-.5-.8-.5-.9-.4-.9-.4-.9-.3-1-.3-.9-.2-1-.2-1-.2-1v-1l-.1-1V58.6z"/>
      <path id="svg_13" class="g0" d="M45.3 64.4V64l.1-.4v-.3l.1-.4v-.4l.2-.4.1-.3.1-.4.2-.3.2-.4.2-.3.2-.3.2-.3.2-.3.3-.3.3-.3.2-.2.3-.3.3-.2.4-.2.3-.2.3-.2.4-.2.3-.1.4-.1.4-.1.3-.1.4-.1h.4l.4-.1h.8l.3.1h.4l.4.1.4.1.4.1.3.1.4.2.4.1.3.2.3.2.4.2.3.3.3.3.3.2.2.3.3.3.2.3.3.3.2.4.2.3.1.4.2.4.1.3.1.4.1.4.1.4.1.4v1.5l-.1.4-.1.4-.1.4-.1.4-.1.3-.2.4-.1.4-.2.3-.2.4-.2.3-.3.3-.3.3-.2.3-.3.3-.3.2-.3.3-.3.2-.4.2-.3.2-.4.2-.4.1-.3.1-.4.2-.4.1H54l-.4.1h-1.5l-.4-.1h-.4l-.4-.1-.4-.2-.3-.1-.4-.1-.4-.2-.3-.2-.4-.2-.3-.2-.3-.3-.3-.2-.3-.3-.3-.3-.2-.2-.2-.4-.3-.3-.2-.3-.2-.4-.2-.3-.1-.4-.1-.4-.2-.4v-.4l-.1-.3-.1-.4v-.8z" fill-rule="evenodd"/>
      <path id="svg_14" class="g2" d="M45.3 64.4V64l.1-.4v-.3l.1-.4v-.4l.2-.4.1-.3.1-.4.2-.3.2-.4.2-.3.2-.3.2-.3.2-.3.3-.3.3-.3.2-.2.3-.3.3-.2.4-.2.3-.2.3-.2.4-.2.3-.1.4-.1.4-.1.3-.1.4-.1h.4l.4-.1h.8l.3.1h.4l.4.1.4.1.4.1.3.1.4.2.4.1.3.2.3.2.4.2.3.3.3.3.3.2.2.3.3.3.2.3.3.3.2.4.2.3.1.4.2.4.1.3.1.4.1.4.1.4.1.4v1.5l-.1.4-.1.4-.1.4-.1.4-.1.3-.2.4-.1.4-.2.3-.2.4-.2.3-.3.3-.3.3-.2.3-.3.3-.3.2-.3.3-.3.2-.4.2-.3.2-.4.2-.4.1-.3.1-.4.2-.4.1H54l-.4.1h-1.5l-.4-.1h-.4l-.4-.1-.4-.2-.3-.1-.4-.1-.4-.2-.3-.2-.4-.2-.3-.2-.3-.3-.3-.2-.3-.3-.3-.3-.2-.2-.2-.4-.3-.3-.2-.3-.2-.4-.2-.3-.1-.4-.1-.4-.2-.4v-.4l-.1-.3-.1-.4v-.8z"/>
      <path id="svg_15" class="g0" d="M93 64.4v-.8l.1-.3v-.4l.1-.4.1-.4.1-.3.2-.4.1-.3.2-.4.2-.3.2-.3.2-.3.3-.3.2-.3.3-.3.3-.2.3-.3.3-.2.3-.2.3-.2.4-.2.3-.2.4-.1.3-.1.4-.1.4-.1.4-.1h.3l.4-.1h.8l.4.1h.4l.4.1.3.1.4.1.4.1.4.2.3.1.4.2.3.2.3.2.3.3.3.3.3.2.3.3.2.3.3.3.2.3.2.4.2.3.2.4.1.4.1.3.2.4.1.4v.4l.1.4v1.5l-.1.4v.4l-.1.4-.2.4-.1.3-.1.4-.2.4-.2.3-.2.4-.2.3-.3.3-.2.3-.3.3-.3.3-.2.2-.4.3-.3.2-.3.2-.4.2-.3.2-.4.1-.4.1-.4.2-.3.1h-.4l-.4.1h-1.6l-.4-.1h-.4l-.3-.1-.4-.2-.4-.1-.4-.1-.3-.2-.4-.2-.3-.2-.4-.2-.3-.3-.3-.2-.2-.3-.3-.3-.3-.2-.2-.4-.2-.3-.2-.3-.3-.4-.1-.3-.2-.4-.1-.4-.1-.4-.1-.4-.1-.3v-.4l-.1-.4v-.4h.1z" fill-rule="evenodd"/>
      <path id="svg_16" class="g2" d="M93 64.4v-.8l.1-.3v-.4l.1-.4.1-.4.1-.3.2-.4.1-.3.2-.4.2-.3.2-.3.2-.3.3-.3.2-.3.3-.3.3-.2.3-.3.3-.2.3-.2.3-.2.4-.2.3-.2.4-.1.3-.1.4-.1.4-.1.4-.1h.3l.4-.1h.8l.4.1h.4l.4.1.3.1.4.1.4.1.4.2.3.1.4.2.3.2.3.2.3.3.3.3.3.2.3.3.2.3.3.3.2.3.2.4.2.3.2.4.1.4.1.3.2.4.1.4v.4l.1.4v1.5l-.1.4v.4l-.1.4-.2.4-.1.3-.1.4-.2.4-.2.3-.2.4-.2.3-.3.3-.2.3-.3.3-.3.3-.2.2-.4.3-.3.2-.3.2-.4.2-.3.2-.4.1-.4.1-.4.2-.3.1h-.4l-.4.1h-1.6l-.4-.1h-.4l-.3-.1-.4-.2-.4-.1-.4-.1-.3-.2-.4-.2-.3-.2-.4-.2-.3-.3-.3-.2-.2-.3-.3-.3-.3-.2-.2-.4-.2-.3-.2-.3-.3-.4-.1-.3-.2-.4-.1-.4-.1-.4-.1-.4-.1-.3v-.4l-.1-.4v-.4h.1zm2.1 29.2l-1.1 1-1 .9-1.2.9-1.2.8-1.2.7-1.3.7-1.3.6-1.3.6-1.4.4-1.4.4-1.3.3-1.4.3-1.5.2-1.4.1h-2.9l-1.4-.2-1.4-.1-1.5-.4-1.4-.3-1.3-.4-1.4-.5-1.3-.6-1.3-.6-1.2-.7-1.3-.7-1.2-.9-1.1-.9-1.1-.9-1-1"/>
      <path id="svg_17" class="g4" d="M110.3 13.5v-.9l.1-.4.1-.4v-.5l.2-.4.1-.4.2-.4.2-.4.2-.4.2-.3.2-.4.3-.4.3-.3.2-.3.3-.4.4-.2.3-.3.4-.3.3-.2.4-.3.4-.1.4-.2.4-.2.4-.2.4-.1.5-.1.4-.1h.4l.5-.1h.8l.5.1h.4l.5.1.4.1.4.2.5.1.4.2.4.2.4.2.4.2.4.3.3.2.4.4.3.3.3.3.3.3.3.4.2.4.3.3.2.5.1.4.3.4.1.4.1.4.1.5.1.4.1.5v1.8l-.1.4v.4l-.2.5-.1.4-.1.4-.2.5-.2.4-.2.4-.3.4-.2.3-.3.4-.3.3-.3.4-.3.3-.4.3-.3.2-.4.3-.4.3-.4.2-.4.1-.4.2-.4.2-.4.1-.5.1-.5.1-.4.1H118l-.4-.1-.5-.1-.4-.1-.5-.1-.4-.1-.4-.2-.4-.2-.4-.2-.4-.3-.4-.2-.4-.3-.3-.3-.3-.3-.3-.3-.3-.4-.3-.3-.2-.4-.3-.4-.2-.4-.2-.4-.1-.4-.2-.4-.2-.4v-.5l-.1-.5-.1-.4-.1-.5v-.4h.1z" fill-rule="evenodd"/>
      <path id="svg_18" class="g2" d="M110.3 13.5v-.9l.1-.4.1-.4v-.5l.2-.4.1-.4.2-.4.2-.4.2-.4.2-.3.2-.4.3-.4.3-.3.2-.3.3-.4.4-.2.3-.3.4-.3.3-.2.4-.3.4-.1.4-.2.4-.2.4-.2.4-.1.5-.1.4-.1h.4l.5-.1h.8l.5.1h.4l.5.1.4.1.4.2.5.1.4.2.4.2.4.2.4.2.4.3.3.2.4.4.3.3.3.3.3.3.3.4.2.4.3.3.2.5.1.4.3.4.1.4.1.4.1.5.1.4.1.5v1.8l-.1.4v.4l-.2.5-.1.4-.1.4-.2.5-.2.4-.2.4-.3.4-.2.3-.3.4-.3.3-.3.4-.3.3-.4.3-.3.2-.4.3-.4.3-.4.2-.4.1-.4.2-.4.2-.4.1-.5.1-.5.1-.4.1H118l-.4-.1-.5-.1-.4-.1-.5-.1-.4-.1-.4-.2-.4-.2-.4-.2-.4-.3-.4-.2-.4-.3-.3-.3-.3-.3-.3-.3-.3-.4-.3-.3-.2-.4-.3-.4-.2-.4-.2-.4-.1-.4-.2-.4-.2-.4v-.5l-.1-.5-.1-.4-.1-.5v-.4h.1z"/>
      <path id="svg_19" class="g4" d="M23.7 13.5v-.9l.1-.4v-.4l.1-.5.2-.4.1-.4.2-.4.1-.4.3-.4.2-.3.2-.4.2-.4.4-.3.2-.3.3-.4.4-.2.3-.3.4-.3.3-.2.4-.3.4-.1.4-.2.4-.2.4-.2.4-.1.5-.1.4-.1h.4l.5-.1h.8l.5.1h.4l.5.1.4.1.4.2.5.1.4.2.4.2.4.2.4.2.4.3.3.2.4.4.3.3.3.3.3.3.3.4.2.4.2.3.3.5.1.4.2.4.2.4.1.4.1.5.1.4.1.5v1.8l-.1.4-.1.4-.1.5-.1.4-.2.4-.1.5-.2.4-.3.4-.2.4-.2.3-.3.4-.3.3-.3.4-.3.3-.4.3-.3.2-.4.3-.4.3-.4.2-.4.1-.4.2-.4.2-.5.1-.4.1-.5.1-.4.1h-1.8l-.5-.1-.4-.1-.5-.1-.4-.1-.4-.1-.4-.2-.4-.2-.4-.2-.4-.3-.4-.2-.4-.3-.3-.3-.3-.3-.3-.3-.3-.4-.3-.3-.2-.4-.3-.4-.2-.4-.2-.4-.2-.4-.1-.4-.2-.4-.1-.5v-.5l-.1-.4-.1-.5v-.4h.1z" fill-rule="evenodd"/>
      <path id="svg_20" class="g2" d="M23.7 13.5v-.9l.1-.4v-.4l.1-.5.2-.4.1-.4.2-.4.1-.4.3-.4.2-.3.2-.4.2-.4.4-.3.2-.3.3-.4.4-.2.3-.3.4-.3.3-.2.4-.3.4-.1.4-.2.4-.2.4-.2.4-.1.5-.1.4-.1h.4l.5-.1h.8l.5.1h.4l.5.1.4.1.4.2.5.1.4.2.4.2.4.2.4.2.4.3.3.2.4.4.3.3.3.3.3.3.3.4.2.4.2.3.3.5.1.4.2.4.2.4.1.4.1.5.1.4.1.5v1.8l-.1.4-.1.4-.1.5-.1.4-.2.4-.1.5-.2.4-.3.4-.2.4-.2.3-.3.4-.3.3-.3.4-.3.3-.4.3-.3.2-.4.3-.4.3-.4.2-.4.1-.4.2-.4.2-.5.1-.4.1-.5.1-.4.1h-1.8l-.5-.1-.4-.1-.5-.1-.4-.1-.4-.1-.4-.2-.4-.2-.4-.2-.4-.3-.4-.2-.4-.3-.3-.3-.3-.3-.3-.3-.3-.4-.3-.3-.2-.4-.3-.4-.2-.4-.2-.4-.2-.4-.1-.4-.2-.4-.1-.5v-.5l-.1-.4-.1-.5v-.4h.1zm89.1 6.2L88.7 39.5M38.5 19.7l24.2 19.8"/>
    </g>
  </g>
</svg>
									</div>
									<?php include_once 'templates/insurance-compare/contact-us-no-results.php' ?>
                                </div>
							<?php else: ?>

								<?php foreach ( $total_array as $insurance_cube ): ?>

                                <?php


									?>
									<?php if ( ! $insurance_cube['mandatory'] || ! $insurance_cube['comprehensive'] ): ?>
										<?php $cube_empties ++; ?>
									<?php endif; ?>


									<?php if ( isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'MAKIF' || $_GET['insurance-type'] == 'ZAD_G' ) ): ?>
										<?php if ( $insurance_cube['mandatory'] && $insurance_cube['comprehensive'] ): ?>
                                            <div class="col-lg-12 px-1 px-lg-2 insurance-cube-wrapper mb-3">

												<?php if ( ! $first_cube && ! $first_cube_count ):
													$first_cube = true;
													?>
                                                    <div class="best-insurance text-center"><?php _e( 'The most affordable price', 'sogoc' ); ?></div>
												<?php endif; ?>

												<?php include 'templates/insurance-compare/insurance-compare-2.php'; ?>
                                            </div>
										<?php else: ?>
											<?php if ( count( $total_array ) == $cube_empties ): ?>
                                                <div class="col-lg-12 px-1 px-lg-2 insurance-cube-wrapper mb-3">
                                                    <p><?php _e( 'No results found', 'sogoc' ); ?></p>
													<?php include 'templates/insurance-compare/contact-us-no-results.php' ?>
                                                </div>
											<?php endif; ?>
										<?php endif; ?>
									<?php else: ?>

										<?php if ( ! is_null( $insurance_cube['price'] ) && absint( $insurance_cube['price'] ) > 0 ): ?>

                                            <div class="col-lg-12 px-1 px-lg-2 insurance-cube-wrapper mb-3">

												<?php if ( ! $first_cube && ! $first_cube_count ):
													$first_cube = true;
													?>
                                                    <div class="best-insurance text-center"><?php _e( 'The most affordable price', 'sogoc' ); ?></div>
												<?php endif; ?>

												<?php include 'templates/insurance-compare/insurance-compare-2.php'; ?>
                                            </div>
										<?php endif; ?>
									<?php endif; ?>


									<?php

									if ( $cube_index === $cube_empties_total + 2 ): ?>
                                        <div class="col-lg-12 text-center mb-3">
<!--                                            <span>--><?php //dynamic_sidebar( $bottom_sidebar ) ?><!--</span>-->
                                            <span><?php dynamic_sidebar( 'bottom_sidebar' ) ?></span>
                                        </div>
									<?php
									endif;
									$cube_index ++;

								endforeach; ?>

							<?php endif; ?>
                        </div>

                        <!-- ROW SIDEBAR -->
                        <div class="row hidden-md-down">

                            <!--                            <div class="col-lg-12 text-center">-->
                            <!--                                <span>--><?php //dynamic_sidebar( 'bottom_sidebar' ) ?><!--</span>-->
                            <!--                            </div>-->

                        </div>

                    </div>

                    <!-- SIDE BANNER -->
                    <div class="col-lg-1 hidden-md-down">
<!--                        <span>--><?php //dynamic_sidebar( $left_sidebar ) ?><!--</span>-->
                        <span><?php dynamic_sidebar( 'left_sidebar' ) ?></span>
                    </div>

                </div>

            </div>

        </section>


        <div class="bottom-right-image">

			<?php echo wp_get_attachment_image( get_field( '_sogo_bottom_right_image' ), 'full' ); ?>

        </div>


        <div class="bottom-left-image">

			<?php echo wp_get_attachment_image( get_field( '_sogo_bottom_left_image' ), 'full' ); ?>

        </div>


    </div>

<?php
if ( isset( $_GET['iframe'] ) && $_GET['iframe'] == '1' ) {
	get_footer( 'iframe' );
} else {
	get_footer();
}
?>
