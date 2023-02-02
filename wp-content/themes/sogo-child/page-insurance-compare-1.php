<?php

/**
 * SESSION START IN OUTER FILE THAT DO INCLUDE oF CURRENT
 */

//ini_set('display_errors', 0);
//error_reporting(E_ALL);

/**
 * SETUP REQUIREMENTS
 */

$ai = $_GET['ai'] ?? 0;

$order_params = [];//handle existing order params if exists or empty array

//Getting current ins_order and his data id exists in db

//if came from any source except Home page/
if ((is_null($_SESSION['tmp_ins_order']) || !isset($_SESSION['tmp_ins_order'])) && !isset($_GET['ins_order'])) {

	$ins_order  = uniqid();
	$_SESSION['ins_orders'][$ins_order]['id']       = $ins_order;
	$_SESSION['ins_orders'][$ins_order]['ins_type'] = $insuranseId;
	$_SESSION['tmp_ins_order'] = $ins_order;

} else if (isset($_GET['ins_order']) && !empty($_GET['ins_order'])) {

	$ins_order = trim(strip_tags($_GET['ins_order']));
    if($ai === '-1') {
        $new_ins_order = uniqid();

        $order_params = get_ins_order($ins_order) ;//get_option('insurance-order_' . $ins_order);
        $_SESSION['ins_orders'][$new_ins_order]['id'] = $new_ins_order;
        $order_params = sogo_clean_step_3($order_params);
        save_ins_order($new_ins_order, $order_params);
      //  update_option('insurance-order_' . $new_ins_order, $order_params);
        $ins_order = $new_ins_order;
    }
    $_SESSION['ins_orders'][$ins_order]['id']       = $ins_order;
    $_SESSION['ins_orders'][$ins_order]['ins_type'] = $insuranseId;


} else {

	if (is_null($_SESSION['ins_orders'][$_SESSION['tmp_ins_order']]['id'])) {
		$_SESSION['ins_orders'][$_SESSION['tmp_ins_order']]['id'] = trim(strip_tags($_SESSION['tmp_ins_order']));
	}

	$ins_order   = $_SESSION['ins_orders'][$_SESSION['tmp_ins_order']]['id'];
	$_SESSION['ins_orders'][$ins_order]['ins_type'] = $insuranseId;


}

$order_params = get_ins_order( $ins_order);//get_option( 'insurance-order_' . $ins_order );


//condition to handle existing order parameters for auto fill second form
if ($order_params !== false) {
	$_SESSION['ins_orders'][$ins_order]['params'] = $order_params;
}



date_default_timezone_set( get_option( 'timezone_string' ) );

?>
    <!--BREADCRUMBS-->
<?php include "templates/content-breadcrumbs.php"; ?>

    <div class="page-insurance-compare-1 pb-5">

        <section class="section-insurance-compare-1">

            <!-- CONTAINER-FLUID -->
            <div class="container-fluid">

                <!-- ROW TITLE-->
                <div class="row justify-content-center mb-3">

                    <div class="col-lg-8">

                        <h1 class="text-1 color-4"><?php the_title(); ?></h1>

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

                                    <div class="time-line d-flex flex-column align-items-center justify-content-center time-line-current">

                                        <span class="time-number">1</span>

                                        <span class="time-text"><?php _e( 'Personal details', 'sogoc' ); ?></span>

                                    </div>

                                    <div class="time-line d-flex flex-column align-items-center justify-content-center time-side-bars">

                                        <span class="time-number">2</span>

                                        <span class="time-text"><?php _e( 'Search results', 'sogoc' ); ?></span>

                                    </div>

                                    <div class="time-line d-flex flex-column align-items-center justify-content-center">

                                        <span class="time-number">3</span>

                                        <span class="time-text"><?php _e( 'Get policy', 'sogoc' ); ?></span>

                                    </div>

                                </div>

                            </div>
						<?php endif; ?>

                        <!-- ROW -->
                        <div class="row mb-5">

                            <!-- INSURANCES TITLE -->
                            <!--                            <div class="col-lg-12 h2 py-3">-->
                            <!---->
                            <!--								--><?php //echo $content; ?>
                            <!---->
                            <!--                            </div>-->

                            <div class="col-lg-12 px-0 px-lg-2">

								<?php
	                            include 'templates/insurance-compare/sami-talk2us-First-step.php';
								include 'templates/insurance-compare/insurance-compare-1.php'; ?>

                            </div>


                        </div>

                        <!-- ROW SIDEBAR -->
                        <div class="row hidden-md-down mb-3">

                            <div class="col-lg-12 text-center">
                                <span><?php dynamic_sidebar( $bottom_sidebar ) ?></span>
                            </div>

                        </div>

                        <!-- row -->
                        <div class="row">
                            <div class="col-12">
                                <div class="entry-content">
									<?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SIDE BANNER -->
                    <div class="col-lg-1 hidden-md-down">
                        <span><?php dynamic_sidebar( $left_sidebar ) ?></span>
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

    <!-- Modal -->
    <div class="modal fade" id="insurance_choose_date" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg top-18vh" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-3 color-4"
                        id="exampleModalLabel"><?php _e( 'Please note - the start date of insurance', 'sogoc' ) ?></h5>
                    <button type="button" class="close text-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-p py-4">
                    <p class="chosen_date d-inline-block"><?php _e( 'If you have insurance that ends on ', 'sogoc' ) ?>
                        <span></span></p>
                    <p class="must_choose d-inline-block"><?php _e( 'You must select beginning insurance starting from ', 'sogoc' ) ?>
                        <span></span></p>
                </div>
                <div class="modal-footer d-flex justify-content-between px-1 px-sm-15">
                    <button type="button" data-choose=""
                            class="s-button s-button-2 w-auto m-0 mr-lg-1 px-1 px-md-2 px-lg-4 bg-5 border-color-5 cursor-pointer btn-default must_choose"><?php _e( 'Change to ', 'sogoc' ) ?>
                        <span></span></button>
                    <button type="button" data-exists="" data-chosen=""
                            class="s-button s-button-2 w-auto m-0 ml-lg-1 px-1 px-md-2 px-lg-4 bg-5 border-color-5 cursor-pointer btn-default chosen_date"><?php _e( 'Leave ', 'sogoc' ) ?>
                        <span></span></button>
                </div>
            </div>
        </div>
    </div>
<?php
	include 'templates/insurance-compare/samiGo2Makif.php';

	if ($_GET['recompare'] == 1)
	include 'templates/insurance-compare/sami-recompare.php';
?>
<?php get_footer(); ?>
