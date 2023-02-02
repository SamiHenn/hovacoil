<?php
// Template name: Hova - iframe

/*
 * checking if session $_SESSION['insurance_results'] for fix in_order ID in url query parameter
 * if yes, overriding wrong in_order ID and reload the page
 */
session_start();
if (isset($_SESSION['insurance_results']) && !empty($_SESSION['insurance_results'])) {

	$url = parse_url($_SERVER['REQUEST_URI']);
	$_SESSION['insurance_results'] = null;
	wp_redirect(site_url('/') . $url['path'] .'?ins_order=' . $_COOKIE['ins_order']);
	exit();
}

//$insurance_type = 'HOVA';
get_header( 'iframe' );
the_post();
$content = get_the_content();

date_default_timezone_set( get_option( 'timezone_string' ) );

$params = isset( $_COOKIE['sogo-form-1'] ) ? stripslashes( $_COOKIE['sogo-form-1'] ) : false;

$params = json_decode( $params );

?>
    <input id="backbuttonstate" value="0" type="text" style="display: none;">
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ibackbutton = document.getElementById("backbuttonstate");
            if (ibackbutton.value == "0") {
                // Page has been loaded for the first time - Set marker
                ibackbutton.value = "1";

            } else {
                var ins = getCookie('ins_order');
                if (ins) {

                    var url = (location.href.indexOf('?ins_order') > 0) ? location.href : location.href + "?ins_order=" + ins;
                    location.href = url;
                }
            }
        }, false);

        function getCookie(name) {
            var re = new RegExp(name + "=([^;]+)");
            var value = re.exec(document.cookie);
            return (value != null) ? unescape(value[1]) : null;
        }
    </script>
    <div class="page-insurance-compare-1 pb-5">

        <section class="section-insurance-compare-1">

            <!-- CONTAINER-FLUID -->
            <div class="container-fluid">

                <!-- ROW TITLE-->
                <div class="row justify-content-center mb-3">

                    <div class="col-lg-8">

                        <h1 class="text-1 color-4"><?php _e( 'Car insurance', 'sogoc' ); ?></h1>

                    </div>

                </div>


                <!-- ROW -->
                <div class="row justify-content-center">

                    <div class="col-lg-7">

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

                        <!-- ROW -->
                        <div class="row mb-5">

                            <!-- INSURANCES TITLE -->
<!--                            <div class="col-lg-12 h2 py-3">-->
<!---->
<!--								--><?php //echo $content; ?>
<!---->
<!--                            </div>-->

                            <div class="col-lg-12">

								<?php
                                //TODO remove this old condition if new condition works fine
								/*if ( isset( $_GET['ins_order'] ) ) {
									$ins_order = $_GET['ins_order'];

									$order_params = get_option( 'insurance-order_' . $ins_order );
								}*/

								/*
                                 * first condition, is for avoid wrong auto fill of the form fields
                                 */
								if (isset($_GET['ins_order']) && isset($_COOKIE['ins_order'])) {

									if ($_GET['ins_order'] == $_COOKIE['ins_order']) {
										$ins_order = $_GET['ins_order'];
									} else {
										$ins_order = $_COOKIE['ins_order'];
									}

									/*
									 * second condition we check if we don't have a cookie
									 */
								} else if ( isset( $_GET['ins_order']) && !isset($_COOKIE['ins_order'])) {
									$ins_order = $_GET['ins_order'];

									/*
									 * third condition we check if we don't have a get parameter
									 */
								} else if (isset($_COOKIE['ins_order']) && !isset( $_GET['ins_order'])) {
									$ins_order = $_COOKIE['ins_order'];
								}

								if (!is_null($ins_order)) {
									$order_params = get_ins_order( $_GET['ins_order']);//get_option( 'insurance-order_' . $ins_order );

								}

								$help_array = array();

								$info_rows = get_field( '_sogo_info_help', 'option' );

								foreach ( $info_rows as $row ) {
									$help_array[ $row['name'] ] = $row['text'];
								}

								?>
                                <form action="<?php echo add_query_arg( array( 'iframe'         => '1',
								                                               'insurance-type' => $insurance_type
								), get_permalink( get_field( '_sogo_insurance_compare_2_link', 'option' ) ) ); ?>"
                                      method="post"
                                      id="form-1">
                                    <input name="ins_link" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>&">
                                    <div id="insurance-accordion" role="tablist" aria-multiselectable="true">

                                        <!-- TAB 1 -->
                                        <div class="card card-current <?php echo isset( $_GET['ins_order'] ) ? 'filled' : ''; ?>">
                                            <div class="card-header" role="tab" id="headingOne">
                                                <h5 class="mb-0 text-5">
                                                    <a data-toggle="collapse" data-target="#collapseOne"
                                                       class="cursor-pointer d-flex align-items-center"
                                                       data-parent="#insurance-accordion" aria-expanded="true"
                                                       aria-controls="collapseOne">

                                                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

														<?php _e( 'Insurance period', 'sogoc' ); ?>

                                                        <p class="d-flex flex-wrap mr-1">
                                                            <span class="d-start"></span>
                                                            <span class="d-middle-line d-none"> - </span>
                                                            <span class="d-end ml-1"></span>


                                                        </p>
                                                    </a>
                                                </h5>
                                            </div>

                                            <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne">
                                                <div class="card-block mb-3">

                                                    <!-- CONTAINER-FLUID -->
                                                    <div class="container-fluid">

                                                        <!-- ROW -->
                                                        <div class="row">

                                                            <div class="col-lg-12">
                                                                <!-- tooltip -->
																<?php sogo_include_tooltip( 'insurance_period', $help_array, __( 'Insurance starting date', 'sogoc' ), $help_array['insurance_period'] ); ?>

                                                                <label for="insurance_period"
                                                                       class="text-5 color-6"><?php _e( 'Insurance starting date', 'sogoc' ); ?></label>

                                                            </div>

                                                            <div class="col-lg-5 s-input-wrapper">

                                                                <div class="form-group date-picker mb-0 hidden-md-down">

                                                                    <input type="text" id="insurance_period" readonly="readonly" name="insurance_period"
                                                                           value="<?php echo isset( $order_params['insurance_period'] ) ? $order_params['insurance_period'] : ''; ?>"
                                                                           class="w-100 medium datepicker"/>


                                                                </div>

                                                                <div class="form-group mb-0 hidden-lg-up">

                                                                    <div class="datepicker static-datepicker"></div>

                                                                </div>

                                                            </div>

                                                            <div class="col">

                                                                <div class="insurance-date-finish-wrapper d-none">

                                                                    <!--                                    <span>-->
																	<?php //_e( 'Insurance period', 'sogoc' ); ?><!--</span>-->
                                                                    <!---->
                                                                    <!--                                    <span class="d-start"></span><span class="d-middle-line d-none"> - </span><span class="d-end"></span>,-->
                                                                    <!---->
                                                                    <!--                                    <span>11 חודשים ו - 15 יום</span>-->

                                                                    <span class="text-5 color-6 normal ml-1">
									   <?php echo __( 'Insurance period', 'sogoc' ) . ': ' ?>
                                    </span>

                                                                    <input type="text" id="insurance-date-start" name="insurance-date-start"
                                                                           class="insurance-date-start text-5 d-inline color-3 bold text-center" readonly/>
                                                                    <label for="insurance-date-start" class="sr-only"></label>
                                                                    <span class="color-3">-</span>
                                                                    <input type="text" id="insurance-date-finish" name="insurance-date-finish" value="
									<?php echo isset( $order_params['insurance-date-finish'] ) ? $order_params['insurance-date-finish'] : ''; ?>"
                                                                           class="insurance-date-finish text-5 d-inline color-3 bold text-center" readonly/>
                                                                    <label for="insurance-date-finish" class="sr-only"></label>


                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <!-- CONTAINER-FLUID -->
                                                <div class="container-fluid mb-3">

                                                    <!-- ROW -->
                                                    <div class="row">

                                                        <div class="col-lg-12">

                                                            <div class="text-left">

																<?php sogo_do_continue_btn(); ?>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <!-- TAB 2 -->
                                        <div class="card <?php echo isset( $_GET['ins_order'] ) ? 'filled' : ''; ?>">
                                            <div class="card-header" role="tab" id="headingTwo">
                                                <h5 class="mb-0 text-5">
                                                    <a class="collapsed d-flex align-items-center flex-wrap" data-toggle="" data-parent="#insurance-accordion"
                                                       href="#collapseTwo"
                                                       aria-expanded="false" aria-controls="collapseTwo">

                                                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

														<?php echo __( 'Car characteristics', 'sogoc' ) . '  '; ?>

                                                        <div class="d-flex flex-wrap selected-header-box"></div>

                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapseTwo" class="collapse content-top" role="tabpanel" aria-labelledby="headingTwo">
                                                <div class="card-block mb-3">

                                                    <!-- CONTAINER-FLUID -->
                                                    <div class="container-fluid">

                                                        <!-- ROW -->
                                                        <div class="row justify-content-between">

                                                            <div class="col-lg-5">
                                                                <!-- row -->
                                                                <div class="row">
                                                                    <!-- Vehicle manufacturer -->
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <!-- tooltip -->
		                                                                <?php sogo_include_tooltip( 'vehicle-manufacturer', $help_array, __( 'Vehicle manufacturer', 'sogoc' ), $help_array['vehicle-manufacturer'] ); ?>

		                                                                <?php
		                                                                $vehicle_manufacturers = sogo_get_manufacturers();
		                                                                if ( ! isset( $_GET['ins_order'] ) ) {
			                                                                sogo_do_select( __( 'Vehicle manufacturer', 'sogoc' ), 'vehicle-manufacturer',
				                                                                $vehicle_manufacturers, true, 1, 'text-to-header' );
		                                                                } else {
			                                                                sogo_do_select_filled( __( 'Vehicle manufacturer', 'sogoc' ), 'vehicle-manufacturer', $vehicle_manufacturers, 'text-to-header', $order_params['vehicle-manufacturer'] );
		                                                                }
		                                                                ?>

                                                                    </div>
                                                                    <!-- Vehicle year -->
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <!-- tooltip -->
		                                                                <?php sogo_include_tooltip( 'vehicle-year', $help_array, __( 'Vehicle year', 'sogoc' ), $help_array['vehicle-year'] ); ?>

		                                                                <?php
		                                                                if ( ! isset( $_GET['ins_order'] ) ) {
			                                                                sogo_do_select( __( 'Vehicle year', 'sogoc' ), 'vehicle-year',
				                                                                array(), false, 1, 'text-to-header' );
		                                                                } else {

			                                                                $vehicle_years = sogo_get_manufacturer_years_filled( $order_params['vehicle-manufacturer'] );
			                                                                sogo_do_select_filled( __( 'year', 'sogoc' ), 'vehicle-year', $vehicle_years, 'text-to-header', $order_params['vehicle-year'] );
		                                                                }
		                                                                ?>

                                                                    </div>
                                                                    <!-- Vehicle brand -->
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <!-- tooltip -->
		                                                                <?php sogo_include_tooltip( 'vehicle-brand', $help_array, __( 'Vehicle brand', 'sogoc' ), $help_array['vehicle-brand'] ); ?>

		                                                                <?php
		                                                                if ( ! isset( $_GET['ins_order'] ) ) {
			                                                                sogo_do_select( __( 'Vehicle brand', 'sogoc' ), 'vehicle-brand',
				                                                                array(), false, 1, 'text-to-header' );
		                                                                } else {
			                                                                $models = sogo_get_models_filled( $order_params['vehicle-manufacturer'], $order_params['vehicle-year'] );
			                                                                sogo_do_select_filled( __( 'Vehicle brand', 'sogoc' ), 'vehicle-brand', $models, 'text-to-header', $order_params['vehicle-brand'] );
		                                                                }
		                                                                ?>

                                                                    </div>
                                                                    <!-- Vehicle sub brand -->
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <!-- tooltip -->
		                                                                <?php sogo_include_tooltip( 'vehicle-sub-brand', $help_array, __( 'Vehicle sub brand', 'sogoc' ), $help_array['vehicle-sub-brand'] ); ?>

		                                                                <?php
		                                                                if ( ! isset( $_GET['ins_order'] ) ) {
			                                                                sogo_do_select( __( 'Vehicle sub brand', 'sogoc' ), 'vehicle-sub-brand',
				                                                                array() );
		                                                                } else {
			                                                                $sub_models = sogo_get_sub_models_filled( $order_params['vehicle-manufacturer'], $order_params['vehicle-year'], $order_params['vehicle-brand'] );
			                                                                sogo_do_select_filled( __( 'Vehicle brand', 'sogoc' ), 'vehicle-sub-brand', $sub_models, '', $order_params['vehicle-sub-brand'] );
		                                                                }
		                                                                ?>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-5">
                                                                <!-- row -->
                                                                <div class="row">
                                                                    <!-- Vehicle gears -->
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <div class="s-radio-wrapper">

                                                                            <!-- tooltip -->
			                                                                <?php sogo_include_tooltip( 'gears', $help_array, __( 'Gears', 'sogoc' ), $help_array['gears'] ); ?>

                                                                            <label class="text-5 color-6 d-inline-block mb-1">
				                                                                <?php _e( 'Gears', 'sogoc' ); ?>
                                                                            </label>

                                                                            <div class="d-flex">

				                                                                <?php
				                                                                if ( ! isset( $_GET['ins_order'] ) ) {
					                                                                $check1 = sogo_if_checked_from_cookie( 'gears', '1' );
					                                                                $check2 = sogo_if_checked_from_cookie( 'gears', '2' );
				                                                                } else {
					                                                                $check1 = $order_params['gears'] == '1' ? 'checked' : '';
					                                                                $check2 = $order_params['gears'] == '2' ? 'checked' : '';
				                                                                }

				                                                                ?>

                                                                                <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                                                                       name="gears" id="gears-1" value="1"
                                                                                       data-val="manual" <?php echo $check1; ?>>
                                                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                       for="gears-1">
					                                                                <?php _e( 'Manual', 'sogoc' ); ?>
                                                                                </label>

                                                                                <input type="radio" class="form-radio-input opacity-0"
                                                                                       name="gears" id="gears-2" value="2"
                                                                                       data-val="automatic" <?php echo $check2; ?>>
                                                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                       for="gears-2">
					                                                                <?php _e( 'Automatic', 'sogoc' ); ?>
                                                                                </label>

                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <!-- Vehicle ownership -->
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <div class="s-radio-wrapper">

                                                                            <!-- tooltip -->
			                                                                <?php sogo_include_tooltip( 'ownership', $help_array, __( 'Vehicle ownership', 'sogoc' ), $help_array['ownership'] ); ?>

                                                                            <label class="text-5 color-6 d-inline-block mb-1">
				                                                                <?php _e( 'Vehicle ownership', 'sogoc' ); ?>
                                                                            </label>

                                                                            <div class="d-flex">

				                                                                <?php
				                                                                if ( ! isset( $_GET['ins_order'] ) ) {
					                                                                $check1 = sogo_if_checked_from_cookie( 'ownership', '1' );
					                                                                $check2 = sogo_if_checked_from_cookie( 'ownership', '2' );
				                                                                } else {
					                                                                $check1 = $order_params['ownership'] == '1' ? 'checked' : '';
					                                                                $check2 = $order_params['ownership'] == '2' ? 'checked' : '';
				                                                                }

				                                                                ?>

                                                                                <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                                                                       name="ownership" id="ownership-1" value="1"
                                                                                       data-val="private" <?php echo $check1; ?>>
                                                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                       for="ownership-1">
					                                                                <?php _e( 'Private', 'sogoc' ); ?>
                                                                                </label>

                                                                                <input type="radio" class="form-radio-input opacity-0"
                                                                                       name="ownership" id="ownership-2" value="2"
                                                                                       data-val="other" <?php echo $check2; ?>>
                                                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                       for="ownership-2">
					                                                                <?php _e( 'Other', 'sogoc' ); ?>
                                                                                </label>

                                                                            </div>

                                                                        </div>

                                                                        <input type="text" name="levi-code" class="d-none" id="levi-code" value=""/>

                                                                    </div>
                                                                    <!-- Vehicle keeping distance system -->
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <div class="s-radio-wrapper">

                                                                            <!-- tooltip -->
			                                                                <?php sogo_include_tooltip( 'keeping-distance-system', $help_array, __( 'Is there keeping distance system', 'sogoc' ), $help_array['keeping-distance-system'] ); ?>

                                                                            <label class="text-5 color-6 d-inline-block mb-1">
				                                                                <?php _e( 'Is there keeping distance system', 'sogoc' ); ?>
                                                                            </label>

                                                                            <div class="d-flex">

				                                                                <?php
				                                                                if ( ! isset( $_GET['ins_order'] ) ) {
					                                                                $check1 = sogo_if_checked_from_cookie( 'keeping-distance-system', '1' );
					                                                                $check2 = sogo_if_checked_from_cookie( 'keeping-distance-system', '2' );
				                                                                } else {
					                                                                $check1 = $order_params['keeping-distance-system'] == '1' ? 'checked' : '';
					                                                                $check2 = $order_params['keeping-distance-system'] == '2' ? 'checked' : '';
				                                                                }

				                                                                ?>

                                                                                <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                                                                       name="keeping-distance-system" id="keeping-distance-system-1" value="1"
                                                                                       data-val="yes" <?php echo $check1; ?>>
                                                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                       for="keeping-distance-system-1">
					                                                                <?php _e( 'Yes', 'sogoc' ); ?>
                                                                                </label>

                                                                                <input type="radio" class="form-radio-input opacity-0"
                                                                                       name="keeping-distance-system" id="keeping-distance-system-2" value="2"
                                                                                       data-val="no" <?php echo $check2; ?>>
                                                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                       for="keeping-distance-system-2">
					                                                                <?php _e( 'No', 'sogoc' ); ?>
                                                                                </label>

                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                    <!-- Vehicle deviation system from lane -->
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <div class="s-radio-wrapper">

                                                                            <!-- tooltip -->
			                                                                <?php sogo_include_tooltip( 'deviation-system', $help_array, __( 'Is there deviation system from lane', 'sogoc' ), $help_array['deviation-system'] ); ?>

                                                                            <label class="text-5 color-6 d-inline-block mb-1">
				                                                                <?php _e( 'Is there deviation system from lane', 'sogoc' ); ?>
                                                                            </label>

                                                                            <div class="d-flex">

				                                                                <?php
				                                                                if ( ! isset( $_GET['ins_order'] ) ) {
					                                                                $check1 = sogo_if_checked_from_cookie( 'deviation-system', '1' );
					                                                                $check2 = sogo_if_checked_from_cookie( 'deviation-system', '2' );
				                                                                } else {
					                                                                $check1 = $order_params['deviation-system'] == '1' ? 'checked' : '';
					                                                                $check2 = $order_params['deviation-system'] == '2' ? 'checked' : '';
				                                                                }

				                                                                ?>

                                                                                <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                                                                       name="deviation-system" id="deviation-system-1" value="1"
                                                                                       data-val="yes" <?php echo $check1; ?>>
                                                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                       for="deviation-system-1">
					                                                                <?php _e( 'Yes', 'sogoc' ); ?>
                                                                                </label>

                                                                                <input type="radio" class="form-radio-input opacity-0"
                                                                                       name="deviation-system" id="deviation-system-2" value="2"
                                                                                       data-val="no" <?php echo $check2; ?>>
                                                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                       for="deviation-system-2">
					                                                                <?php _e( 'No', 'sogoc' ); ?>
                                                                                </label>

                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>


                                                        </div>

                                                    </div>

                                                </div>

                                                <!-- CONTAINER-FLUID -->
                                                <div class="container-fluid mb-3">

                                                    <!-- ROW -->
                                                    <div class="row">

                                                        <div class="col-lg-12">

                                                            <div class="text-left">

																<?php sogo_do_continue_btn(); ?>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                        <!-- TAB 3 -->
                                        <div class="card <?php echo isset( $_GET['ins_order'] ) ? 'filled' : ''; ?>">
                                            <div class="card-header" role="tab" id="headingThree">
                                                <h5 class="mb-0 text-5">
                                                    <a class="collapsed d-flex align-items-center flex-wrap" data-toggle="" data-parent="#insurance-accordion"
                                                       href="#collapseThree"
                                                       aria-expanded="false" aria-controls="collapseThree">

                                                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

														<?php _e( 'Driver characteristics', 'sogoc' ); ?>

                                                        <div class="d-flex flex-wrap selected-header-box"></div>

                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapseThree" class="collapse content-top" role="tabpanel" aria-labelledby="headingThree">
                                                <div class="card-block mb-3">

                                                    <!-- CONTAINER-FLUID -->
                                                    <div class="container-fluid">

                                                        <!-- ROW -->
                                                        <div class="row justify-content-between">

                                                            <div class="col-lg-5">
                                                                <!-- row -->
                                                                <div class="row">
                                                                    <!-- Youngest driver's age -->
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <!-- tooltip -->
																		<?php sogo_include_tooltip( 'youngest-driver', $help_array, __( 'Youngest driver\'s age', 'sogoc' ), $help_array['youngest-driver'] ); ?>

																		<?php
																		$min_age = '17';
																		$max_age = '81';
																		$ages    = array();
																		$index   = 17;

																		for ( $i = $min_age; $i < $max_age; $i ++ ) {

																			if ( $index == 80 ) {
																				array_push( $ages, $index . '+' );
																			} else {
																				array_push( $ages, $index );
																			}

																			$index ++;
																		}

																		if ( ! isset( $_GET['ins_order'] ) ) {
																			sogo_do_select( __( 'Youngest driver\'s age', 'sogoc' ), 'youngest-driver',
																				$ages, false, $min_age, 'text-to-header' );
																		} else {
																			sogo_do_select_filled( __( 'Youngest driver\'s age', 'sogoc' ), 'youngest-driver', $ages, 'text-to-header', $order_params['youngest-driver'] );
																		}
																		?>

                                                                    </div>
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <!-- tooltip -->
																		<?php sogo_include_tooltip( 'lowest-seniority', $help_array, __( 'Lowest driving seniority', 'sogoc' ), $help_array['lowest-seniority'] ); ?>

																		<?php
																		$min_seniority = '0';
																		$max_seniority = '31';
																		$seniority     = array();
																		$index         = 0;

																		for ( $i = $min_seniority; $i < $max_seniority; $i ++ ) {

																			if ( $index == 30 ) {
																				array_push( $seniority, $index . '+' );
																			} else {
																				array_push( $seniority, $index );
																			}

																			$index ++;
																		}

																		if ( ! isset( $_GET['ins_order'] ) ) {
																			sogo_do_select( __( 'Lowest driving seniority', 'sogoc' ), 'lowest-seniority',
																				$seniority, false, $min_seniority );
																		} else {
																			sogo_do_select_filled( __( 'Lowest driving seniority', 'sogoc' ), 'lowest-seniority', $seniority, '', $order_params['lowest-seniority'] );
																		}
																		?>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-5">
                                                                <!-- row -->
                                                                <div class="row">
                                                                    <!-- Number of people allowed to drive in vehicle -->
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <!-- tooltip -->
																		<?php sogo_include_tooltip( 'drive-allowed-number', $help_array, __( 'Number allowed to drive', 'sogoc' ), $help_array['drive-allowed-number'] ); ?>

																		<?php
																		if ( ! isset( $_GET['ins_order'] ) ) {
																			sogo_do_select( __( 'Number allowed to drive', 'sogoc' ), 'drive-allowed-number',
																				array(
																					'נהג יחיד',
																					'2 נהגים',
																					'3 נהגים',
																					'כל נהג'
																				), false, 1, 'text-to-header' );
																		} else {
																			sogo_do_select_filled_key( __( 'Number allowed to drive', 'sogoc' ), 'drive-allowed-number', array(
																				'נהג יחיד',
																				'2 נהגים',
																				'3 נהגים',
																				'כל נהג'
																			), 'text-to-header', $order_params['drive-allowed-number'] );
																		}
																		?>

                                                                    </div>

                                                                    <!-- Youngest driver's gender -->
                                                                    <div class="col-12 mb-2 mb-lg-3">

                                                                        <div class="s-radio-wrapper">

                                                                            <!-- tooltip -->
																			<?php sogo_include_tooltip( 'gender', $help_array, __( 'Youngest driver\'s gender', 'sogoc' ), $help_array['gender'] ); ?>

                                                                            <label class="text-5 color-6 d-inline-block mb-1">
																				<?php _e( 'Youngest driver\'s gender', 'sogoc' ); ?>
                                                                            </label>

                                                                            <div class="d-flex">

																				<?php
																				if ( ! isset( $_GET['ins_order'] ) ) {
																					$check1 = sogo_if_checked_from_cookie( 'gender', '1' );
																					$check2 = sogo_if_checked_from_cookie( 'gender', '2' );
																				} else {
																					$check1 = $order_params['gender'] == '1' ? 'checked' : '';
																					$check2 = $order_params['gender'] == '2' ? 'checked' : '';
																				}

																				?>

                                                                                <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                                                                       name="gender" id="gender-1" value="1"
                                                                                       data-val="male" <?php echo $check1; ?>>
                                                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                       for="gender-1">
																					<?php _e( 'Male', 'sogoc' ); ?>
                                                                                </label>

                                                                                <input type="radio" class="form-radio-input opacity-0"
                                                                                       name="gender" id="gender-2" value="2"
                                                                                       data-val="female" <?php echo $check2; ?>>
                                                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                                       for="gender-2">
																					<?php _e( 'Female', 'sogoc' ); ?>
                                                                                </label>

                                                                            </div>

                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <!-- CONTAINER-FLUID -->
                                                <div class="container-fluid mb-3">

                                                    <!-- ROW -->
                                                    <div class="row">

                                                        <div class="col-lg-12">

                                                            <div class="text-left">

																<?php sogo_do_continue_btn(); ?>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>


                                        <!-- TAB 4 -->
                                        <div class="card <?php echo isset( $_GET['ins_order'] ) ? 'filled' : ''; ?>">
                                            <div class="card-header" role="tab" id="headingFour">
                                                <h5 class="mb-0 text-5">
                                                    <a class="collapsed d-flex align-items-center flex-wrap" data-toggle="" data-parent="#insurance-accordion"
                                                       href="#collapseFour"
                                                       aria-expanded="false" aria-controls="collapseThree">

                                                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

														<?php _e( 'Insurance records', 'sogoc' ); ?>

                                                        <div class="d-flex flex-wrap selected-header-box"></div>

                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapseFour" class="collapse content-top" role="tabpanel" aria-labelledby="headingFour">
                                                <div class="card-block mb-3">

                                                    <!-- CONTAINER-FLUID -->
                                                    <div class="container-fluid">

                                                        <!-- ROW -->
                                                        <div class="row justify-content-between">

                                                            <!-- Was there insurance before -->
                                                            <div class="col-lg-5 mb-3">

                                                                <div class="s-radio-wrapper">

                                                                    <!-- tooltip -->
																	<?php sogo_include_tooltip( 'insurance-before', $help_array, __( 'Was there insurance before', 'sogoc' ), $help_array['insurance-before'] ); ?>

                                                                    <label class="text-5 color-6 d-inline-block mb-1">
																		<?php _e( 'Was there insurance before', 'sogoc' ); ?>
                                                                    </label>

                                                                    <div class="d-flex">

																		<?php
																		if ( ! isset( $_GET['ins_order'] ) ) {
																			$check1 = sogo_if_checked_from_cookie( 'insurance-before', '1' );
																			$check2 = sogo_if_checked_from_cookie( 'insurance-before', '2' );
																		} else {
																			$check1 = $order_params['insurance-before'] == '1' ? 'checked' : '';
																			$check2 = $order_params['insurance-before'] == '2' ? 'checked' : '';
																		}

																		?>

                                                                        <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                                                               name="insurance-before" id="insurance-before-1" value="1"
                                                                               data-val="yes" <?php echo $check1; ?>>
                                                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                               for="insurance-before-1">
																			<?php _e( 'Yes', 'sogoc' ); ?>
                                                                        </label>

                                                                        <input type="radio" class="form-radio-input opacity-0"
                                                                               name="insurance-before" id="insurance-before-2" value="2"
                                                                               data-val="no" <?php echo $check2; ?>>
                                                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                               for="insurance-before-2">
																			<?php _e( 'No', 'sogoc' ); ?>
                                                                        </label>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <!-- ROW -->
                                                        <div class="row justify-content-between d-none">

                                                            <!-- Insurance a year ago -->
                                                            <div class="col-lg-5 mb-3">

                                                                <!-- tooltip -->
																<?php sogo_include_tooltip( 'insurance-1-year', $help_array, __( 'A year ago', 'sogoc' ), $help_array['insurance-1-year'] ); ?>

																<?php
															//	if ( ! isset( $_GET['ins_order'] ) ) {
																	sogo_do_select( __( 'A year ago', 'sogoc' ), 'insurance-1-year',
																		array(
																			'מקיף',
																			'צד ג',
																			'לא היה'
																		) );
																//} else {
//																	sogo_do_select_filled_key( __( 'A year ago', 'sogoc' ), 'insurance-1-year', array(
//																		'מקיף',
//																		'צד ג',
//																		'לא היה'
//																	), '', $order_params['insurance-1-year'] );
															//	}
																?>

                                                            </div>

                                                            <!-- Insurance two years ago -->
                                                            <div class="col-lg-5 mb-3">

                                                                <!-- tooltip -->
																<?php sogo_include_tooltip( 'insurance-2-year', $help_array, __( 'Two years ago', 'sogoc' ), $help_array['insurance-2-year'] ); ?>

																<?php
																//if ( ! isset( $_GET['ins_order'] ) ) {
																	sogo_do_select( __( 'Two years ago', 'sogoc' ), 'insurance-2-year',
																		array(
																			'מקיף',
																			'צד ג',
																			'לא היה'
																		) );
															//	} else {
//																	sogo_do_select_filled_key( __( 'Two years ago', 'sogoc' ), 'insurance-2-year', array(
//																		'מקיף',
//																		'צד ג',
//																		'לא היה'
//																	), '', $order_params['insurance-2-year'] );
//																}
																?>

                                                            </div>

                                                            <!-- Insurance three years ago -->
                                                            <div class="col-lg-5 mb-3">

                                                                <!-- tooltip -->
																<?php sogo_include_tooltip( 'insurance-3-year', $help_array, __( 'Three years ago', 'sogoc' ), $help_array['insurance-3-year'] ); ?>

																<?php
															//	if ( ! isset( $_GET['ins_order'] ) ) {
																	sogo_do_select( __( 'Three years ago', 'sogoc' ), 'insurance-3-year',
																		array(
																			'מקיף',
																			'צד ג',
																			'לא היה'
																		) );
//																} else {
//																	sogo_do_select_filled_key( __( 'Three years ago', 'sogoc' ), 'insurance-3-year', array(
//																		'מקיף',
//																		'צד ג',
//																		'לא היה'
//																	), '', $order_params['insurance-3-year'] );
//																}
																?>

                                                            </div>

                                                            <!-- Did you had law suites in last 3 years -->
                                                            <div class="col-lg-5 mb-3">

                                                                <!-- tooltip -->
																<?php sogo_include_tooltip( 'law-suites-3-year', $help_array, __( 'Did you had law suites in last 3 years', 'sogoc' ), $help_array['law-suites-3-year'] ); ?>

																<?php
																//if ( ! isset( $_GET['ins_order'] ) ) {
																	sogo_do_select( __( 'Did you had law suites in last 3 years', 'sogoc' ), 'law-suites-3-year',
																		array(
																			'לא היו',
																			'תביעה 1',
																			'2 ומעלה'
																		), false, 0 );
//																} else {
//																	sogo_do_select_filled_key( __( 'Three years ago', 'sogoc' ), 'law-suites-3-year', array(
//																		'לא היו',
//																		'תביעה 1',
//																		'2 ומעלה'
//																	), '', $order_params['law-suites-3-year'], true );
//																}
																?>

                                                            </div>
                                                        </div>

                                                        <!-- ROW -->
                                                        <!--                        <div class="row justify-content-between d-none">-->
                                                        <!---->
                                                        <!---->
                                                        <!---->
                                                        <!--                        </div>-->

                                                        <!-- ROW -->
                                                        <div class="row justify-content-between d-none">

                                                            <!-- What year was the law suite -->
                                                            <div class="col-lg-5 mb-3">

                                                                <!-- tooltip -->
																<?php sogo_include_tooltip( 'law-suite-what-year', $help_array, __( 'What year was the law suite', 'sogoc' ), $help_array['law-suite-what-year'] ); ?>

																<?php
															//	if ( ! isset( $_GET['ins_order'] ) ) {
																	sogo_do_select( __( 'What year was the law suite', 'sogoc' ), 'law-suite-what-year',
																		array(
																			'שנה אחרונה',
																			'לפני שנתיים',
																			'לפני שלוש שנים'
																		) );
//																} else {
//																	sogo_do_select_filled_key( __( 'What year was the law suite', 'sogoc' ), 'law-suite-what-year', array(
//																		'שנה אחרונה',
//																		'לפני שנתיים',
//																		'לפני שלוש שנים'
//																	), '', $order_params['law-suite-what-year'] );
//																}
																?>

                                                            </div>

                                                            <!-- Where there body claims -->
                                                            <div class="col-lg-5 mb-lg-3">

                                                                <!-- tooltip -->
																<?php sogo_include_tooltip( 'body-claims', $help_array, __( 'Where there body claims', 'sogoc' ), $help_array['body-claims'] ); ?>

																<?php
																if ( ! isset( $_GET['ins_order'] ) ) {
																	sogo_do_select( __( 'Where there body claims', 'sogoc' ), 'body-claims',
																		array(
																			'לא היו',
																			'תביעה 1',
																			'2 ומעלה'
																		), false, 0 );
																} else {
																	sogo_do_select_filled_key( __( 'What year was the law suite', 'sogoc' ), 'body-claims', array(
																		'לא היו',
																		'תביעה 1',
																		'2 ומעלה'
																	), '', $order_params['body-claims'] );
																}
																?>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <!-- CONTAINER-FLUID -->
                                                <div class="container-fluid mb-3">

                                                    <!-- ROW -->
                                                    <div class="row">

                                                        <div class="col-lg-12">

                                                            <div class="text-left">

																<?php sogo_do_continue_btn(); ?>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>


                                        <!-- TAB 5 -->
                                        <div class="card">
                                            <div class="card-header" role="tab" id="headingFive">
                                                <h5 class="mb-0 text-5">
                                                    <a class="collapsed d-flex align-items-center" data-toggle="" data-parent="#insurance-accordion"
                                                       href="#collapseFive"
                                                       aria-expanded="false" aria-controls="collapseFive">

                                                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

														<?php _e( 'Additional information', 'sogoc' ); ?>

                                                        <div class="d-flex flex-wrap selected-header-box"></div>

                                                    </a>
                                                </h5>
                                            </div>
                                            <div id="collapseFive" class="collapse content-top" role="tabpanel" aria-labelledby="headingFive">
                                                <div class="card-block mb-3">

                                                    <!-- CONTAINER-FLUID -->
                                                    <div class="container-fluid">

                                                        <!-- ROW -->
                                                        <div class="row justify-content-between">

                                                            <!-- Criminal record -->
                                                            <div class="col-lg-5 mb-3">

                                                                <div class="s-radio-wrapper">

                                                                    <!-- tooltip -->
																	<?php sogo_include_tooltip( 'criminal-record', $help_array, __( 'Criminal record', 'sogoc' ), $help_array['criminal-record'] ); ?>

                                                                    <label class="text-5 color-6 d-inline-block mb-1">
																		<?php _e( 'Criminal record', 'sogoc' ); ?>
                                                                    </label>

                                                                    <div class="d-flex">

																		<?php
																		if ( ! isset( $_GET['ins_order'] ) ) {
																			$check1 = sogo_if_checked_from_cookie( 'criminal-record', '1' );
																			$check2 = sogo_if_checked_from_cookie( 'criminal-record', '2' );
																		} else {
																			$check1 = $order_params['criminal-record'] == '1' ? 'checked' : '';
																			$check2 = $order_params['criminal-record'] == '2' ? 'checked' : '';
																		}
																		?>

                                                                        <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                                                               name="criminal-record" id="criminal-record-1" value="1"
                                                                               data-val="yes" <?php echo $check1; ?>>
                                                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                               for="criminal-record-1">
																			<?php _e( 'Yes', 'sogoc' ); ?>
                                                                        </label>

                                                                        <input type="radio" class="form-radio-input opacity-0"
                                                                               name="criminal-record" id="criminal-record-2" value="2"
                                                                               data-val="no" <?php echo $check2; ?>>
                                                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                                               for="criminal-record-2">
																			<?php _e( 'No', 'sogoc' ); ?>
                                                                        </label>

                                                                    </div>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <!-- ROW -->
                                                        <div class="row justify-content-between">

                                                            <!-- License suspensions -->
                                                            <div class="col-lg-5 mb-3">

                                                                <!-- tooltip -->
																<?php sogo_include_tooltip( 'license-suspensions', $help_array, __( 'License suspensions', 'sogoc' ), $help_array['license-suspensions'] ); ?>

																<?php
																if ( ! isset( $_GET['ins_order'] ) ) {
																	sogo_do_select( __( 'License suspensions', 'sogoc' ), 'license-suspensions',
																		array(
																			'0',
																			'1',
																			'2',
																			'כרגע בשלילה'
																		), false, 0 );
																} else {
																	sogo_do_select_filled_key( __( 'License suspensions', 'sogoc' ), 'license-suspensions', array(
																		'0',
																		'1',
																		'2',
																		'כרגע בשלילה'
																	), '', $order_params['license-suspensions'], true );
																}
																?>

                                                            </div>

                                                            <!-- City -->
                                                            <div class="col-lg-5 s-input-wrapper">
                                                                <div class="form-group">

                                                                    <label for="city"
                                                                           class="text-5 color-6 d-block mb-1"><?php echo __( 'City of residence', 'sogoc' ); ?></label>

                                                                    <input type="text" id="city" name="city" class="w-100"
                                                                           value="<?php echo isset( $_GET['ins_order'] ) ? $order_params['city'] : ''; ?>"/>

                                                                </div>
                                                            </div>

                                                        </div>

                                                        <!-- ROW -->
                                                        <div class="row justify-content-between">

                                                            <!-- Terms & conditions 1 -->
                                                            <div class="col-lg-12">

                                                                <div class="form-group">

                                                                    <input type="checkbox"
                                                                           name="tac-1" <?php echo isset( $_GET['ins_order'] ) ? 'checked' : ''; ?>
                                                                           class="form-control tac-1 opacity-0"
                                                                           id="tac-1"/>
																	<?php if ( array_key_exists( 'tac-1', $help_array ) ): ?>
                                                                        <span class="info-help">
                                            <?php echo $help_array['tac-1']; ?>
                                        </span>
																	<?php endif; ?>

                                                                    <label for="tac-1"
                                                                           class="d-flex align-items-center checkbox-label text-5 color-6 flex-wrap">

                                                                        <span class="font-09em"><?php _e( 'Agree to the using condition', 'sogoc' ); ?></span>
                                                                        -
                                                                        <span><a target="_blank"
                                                                                 href="<?php the_field( '_sogo_site_tac', 'option' ); ?>"
                                                                                 class="underline"><?php _e( 'to site terms', 'sogoc' ); ?></a></span>

                                                                    </label>

                                                                </div>

                                                                <!-- hidden fields -->
                                                                <input type="text" name="insurance-type" class="d-none"
                                                                       value="<?php echo $insurance_type; ?>"/>

                                                            </div>


                                                        </div>

                                                    </div>

                                                </div>

                                                <!-- CONTAINER-FLUID -->
                                                <div class="container-fluid mb-3">

                                                    <!-- ROW -->
                                                    <div class="row">

                                                        <div class="col-lg-12">

                                                            <div class="text-left">

                                                                <button type="submit" class="s-button s-button-2 bg-5 border-color-5 insurance-submit-1">
                                                                    <span><?php _e( 'Send', 'sogoc' ); ?></span>
                                                                    <i class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>
                                                                </button>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                </form>

                            </div>

                        </div>

                        <!-- ROW SIDEBAR -->
                        <div class="row hidden-md-down">

                            <div class="col-lg-12 text-center">
                                <span><?php dynamic_sidebar( $bottom_sidebar ) ?></span>
                            </div>

                        </div>

                    </div>

                    <!-- SIDE BANNER -->
                    <div class="col-lg-1 hidden-md-down">
                        <span><?php dynamic_sidebar( $left_sidebar  ) ?></span>
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
    <div class="modal fade" id="insurance_choose_date" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg top-18vh" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-3 color-4" id="exampleModalLabel"><?php _e( 'Please note - the start date of insurance', 'sogoc' ) ?></h5>
                    <button type="button" class="close text-4" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-p py-4">
                    <p class="chosen_date d-inline-block"><?php _e( 'If you have insurance that ends on ', 'sogoc' ) ?><span></span></p>
                    <p class="must_choose d-inline-block"><?php _e( 'You must select beginning insurance starting from ', 'sogoc' ) ?><span></span></p>
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

<?php get_footer( 'iframe' ); ?>
