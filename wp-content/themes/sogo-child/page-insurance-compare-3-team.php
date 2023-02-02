<?php
// Template Name: page insurance compare 3 team
//ini_set( 'display_errors', 1 );
//error_reporting( E_ALL );
session_start();

//header( 'Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0' );
//header( 'Pragma: no-cache' );
//header( 'Expires: Fri, 01 Jan 1990 00:00:00 GMT' );

$ins_order = null;
global $order_params;

//if agent come to edit policy info
if ( isset( $_GET['ins_order'] ) && !empty( $_GET['ins_order'] )) {
	$ins_order = trim(strip_tags($_GET['ins_order']));

} else {
	header( 'Location: http://' . $_SERVER['HTTP_HOST'] );
	exit();
}

//if order is exist in crm, we check also count of order params
//by default from new order is 3
if (isset($_SESSION['ins_orders'][$ins_order]['params']) && count($_SESSION['ins_orders'][$ins_order]['params']['order_details']) > 3) {

	$order_params = $_SESSION['ins_orders'][$ins_order]['params'];

} else {//nwe order

	$order_params = get_option( 'insurance-order_' . $ins_order );

	$_SESSION['ins_orders'][$ins_order]['params'] = $order_params;
	$_SESSION['ins_orders'][$ins_order]['id']     = $ins_order;

}

//change mandatory price to price of companies mix
//if (isset($_SESSION['ins_orders'][$ins_order]['hova'])) {
//    die();
//	$order_params['order_details']['mandat_price'] = isset($_SESSION['ins_orders'][$ins_order]['hova']['mandat_price']) ? $_SESSION['ins_orders'][$ins_order]['hova']['mandat_price'] : $_SESSION['ins_orders'][$ins_order]['hova']['price'];
//
//}


//for control valid titles
if (isset($_SESSION['ins_orders'][$ins_order]['ins_type']) && !empty($_SESSION['ins_orders'][$ins_order]['ins_type'])) {
	$insType = $_SESSION['ins_orders'][$ins_order]['ins_type'];
} else {
	$insType = $order_params['order_details']['in_type'];

	$_SESSION['ins_orders'][$ins_order]['ins_type'] = $insType;
}

//avoid errors in crm. setting up ins_order from session not from post or get
if (!$order_params['order_details']['ins_order']) {
	$order_params['order_details']['ins_order'] = $ins_order;
}

$companies_settings = array();
$comp_repeater      = get_field( '_sogo_insurance_companies', 'option' );

foreach ( $comp_repeater as $comp ) {

	$companies_settings[ $comp['company_id'] ] = array(
		'company_id'               => $comp['company_id'],
		'mf_company_name'          => $comp['mf_company_name'],
		'crm_company_name'         => $comp['crm_company_name'],
		'mandatory_num_payments'   => $comp['mandatory_num_payments'],
		'other_num_payments'       => $comp['other_num_payments'],
		'havila_num_payments'      => $comp['other_num_payments_havila'],
		'use_makif'                => $comp['use_makif'],
		'use_zad_g'                => $comp['use_zad_g'],
		'use_hova'                 => $comp['use_hova'],
		'limited_in_amount'        => $comp['limited_in_amount'],
		'fixed_discount'           => $comp['fixed_discount'],
		'protection'               => $comp['_sogo_protection'],
		'api_exists'               => $comp['api_exists'],
		'num_payments_no_percents' => $comp['other_num_payments_no_percents'],
		'upsales_number_payments'  => $comp['upsales_number_payments'],
	);
}

$title = "";

switch ( $insType ) {
	case 1:
		$title = get_field( '_sogo_order_page_hova' );
		$link  = get_field( '_sogo_link_to_thank_1', 'option' );
		break;
	case 2:
		$title = get_field( '_sogo_order_page_mekif' );
		$link  = get_field( '_sogo_link_to_thank_2', 'option' );
		break;
	case 3:
		$title = get_field( '_sogo_order_page_zadg' );
		$link  = get_field( '_sogo_link_to_thank_3', 'option' );
		break;
	default:
		$title = '';
		$link  = '';
}

// setting up params for figure out , if the agent is edit order
$agentId        = $_GET['ai']  ?? $_SESSION['ai'] ;
$src            = $_GET['src'] ?? $_SESSION['src'];

if ( isset( $_GET['iframe'] ) && $_GET['iframe'] == '1' ) {
	get_header( 'iframe' );
} else {
	get_header();
}


the_post();
date_default_timezone_set( get_option( 'timezone_string' ) );
?>
<?php // if ( ! isset( $_GET['iframe'] ) ): ?>
    <!--BREADCRUMBS-->
	<?php // include "templates/content-breadcrumbs.php"; ?>
<?php // endif; ?>
    <div class="page-insurance-compare-1 pb-5">

        <section class="section-insurance-compare-1">

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

                    <div class="col-lg-10 col-xl-7">
						<?php if ( ! wp_is_mobile() ): ?>
                            <!-- ROW -->
                            <div class="row text-center mb-3">

                                <!-- TIME LINE -->
                                <div class="col-lg-12 d-flex justify-content-between">

                                    <div class="time-line d-flex flex-column align-items-center justify-content-center time-line-finish">

                                        <span class="time-number">1</span>

                                        <span class="time-text"><?php _e( 'Personal details', 'sogoc' ); ?></span>

                                    </div>

                                    <div class="time-line d-flex flex-column align-items-center justify-content-center time-side-bars time-line-finish-2">

                                        <span class="time-number">2</span>

                                        <span class="time-text"><?php _e( 'Search results', 'sogoc' ); ?></span>

                                    </div>

                                    <div class="time-line d-flex flex-column align-items-center justify-content-center time-line-blue time-line-current">

                                        <span class="time-number">3</span>

                                        <span class="time-text"><?php _e( 'Get policy', 'sogoc' ); ?></span>

                                    </div>

                                </div>

                            </div>
						<?php endif; ?>
	<?php include "templates/insurance-compare/sami-talk2us.php"; ?>

                        <!-- ROW -->
                        <div class="row mb-5">
                    <!-- sami deal prices -->
<div class="col-lg-12 px-0 px-lg-2 mb-1">
<div style="float: right; border: 1px solid #c0c0c0; border-radius: 7px" class="bg-white p-1 col-lg-12">
<div style="float: right" class="col-lg-4"><span class="text-5 color-4">חברת ביטוח: </span><span class="text-6 color-3 d-inline-block"><?php echo $order_params['order_details']['ins_company']; ?></span></div>
	<div style="float: right" class="col-lg-4"><span class="text-5 color-4">ביטוח חובה: </span><span class="text-6 color-3 d-inline-block"><?php echo  number_format($order_params['order_details']['mandat_price']); ?> ש"ח</span></div>
<?php
					if ( isset( $order_params['order_details']['price_havila'] ) && $order_params['order_details']['price_havila'] > 0 ) {
						$price = intval( $order_params['order_details']['second_price'] ) - intval( $order_params['order_details']['price_havila'] );
					} else {
						$price = $order_params['order_details']['second_price'];
					}
					?>
<div style="float: right" class="col-lg-4 <?php if($order_params['order_details']['in_type'] == 1) echo 'd-none';?>">
<span class="text-5 color-4"><?php if($order_params['order_details']['in_type'] == 3) echo 'ביטוח צד ג: '; else echo'ביטוח מקיף: ';?></span><span class="text-6 color-3 d-inline-block"><?php echo (int) $order_params['order_details']['in_type']!== 1 ? number_format($price +  $order_params['order_details']['price_havila']) : ''; ?> ש"ח</span>
</div></div></div>
                            <!-- INSURANCES TITLE -->
                            <div class="col-lg-12 entry-content">

								<?php


								the_content(); ?>

                            </div>

                            <div class="col-lg-12 px-0 px-lg-2">

								<?php include 'templates/insurance-compare/insurance-compare-3-team.php'; ?>


                                <!-- ROW SIDEBAR -->
                                <div class="row hidden-md-down mt-5">

                                    <div class="col-lg-12 text-center">
<!--                                        <span>--><?php //dynamic_sidebar( $bottom_sidebar ) ?><!--</span>-->
                                        <span><?php dynamic_sidebar('bottom_sidebar') ?></span>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- SIDE BANNER -->
                <div class="col-lg-1 hidden-md-down">
<!--                    <span>--><?php //dynamic_sidebar( $left_sidebar ) ?><!--</span>-->
                    <span><?php dynamic_sidebar( 'left_sidebar' ) ?></span>
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

    <!-- Modal -->
    <div class="modal fade" id="insurance_choose_date" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php _e( 'Please note - the start date of insurance', 'sogoc' ) ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="chosen_date"><?php _e( 'If you have insurance that ends on ', 'sogoc' ) ?><span></span></p>
                    <p class="must_choose"><?php _e( 'You must select beginning insurance starting from ', 'sogoc' ) ?><span></span></p>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" data-choose="" class="btn cursor-pointer btn-default must_choose"><?php _e( 'Change to ', 'sogoc' ) ?><span></span>
                    </button>
                    <button type="button" data-exists="" data-chosen="" class="btn cursor-pointer btn-default chosen_date"><?php _e( 'Leave ', 'sogoc' ) ?>
                        <span></span></button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="insurance_price_message" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="insurance_payments_message">

                    <p  id="insurance_final_price" class="text-4 color-3 text-center"></p>
                </div>
            </div>
        </div>
    </div>


<?php //require_once dirname( __FILE__ ) . '/insurance-api/ayalon/index.php';?>

<?php //echo '----------------------------------------'; ?>

<?php //require_once dirname( __FILE__ ) . '/insurance-api/shirbit/index.php';?>

<?php
if ( isset( $_GET['iframe'] ) && $_GET['iframe'] == '1' ) {
	get_footer( 'iframe' );
} else {
	get_footer();
}
?>