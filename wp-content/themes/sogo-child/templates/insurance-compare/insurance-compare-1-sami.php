<?php

$help_array = array();

$info_rows = get_field( '_sogo_info_help', 'option' );

foreach ( $info_rows as $row ) {
	$help_array[ $row['name'] ] = $row['text'];
}
$esp = $fcw= $ldw = '';
if(isset($order_params['order_details'])){
    $esp = $order_params['order_details']['stability-system'];
    $fcw = $order_params['order_details']['keeping-distance-system'];
    $ldw = $order_params['order_details']['deviation-system'];

}

?>
<form action="<?php echo add_query_arg( 'insurance-type', $insurance_type, get_permalink( get_field( '_sogo_insurance_compare_2_link', 'option' ) ) ); ?>"
      method="post"
      id="form-1">
    <input type="hidden" name="ins_order" value="<?php echo $_SESSION['ins_orders'][$ins_order]['id'];?>">

    <input type="hidden" name="engine_capacity" value="<?php echo $order_params !== false ?  $order_params['order_details']['engine_capacity']: '';?>">
    <input name="ins_link" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
    <!--    <input name="aff"      type="hidden" value="--><?php //echo $_SESSION['aff'] ;?><!--">-->
    <input name="in_type"  type="hidden" value="<?php echo ((int)$_SESSION['ins_orders'][$ins_order]['ins_type'] !== (int)$insuranseId ? $insuranseId : $_SESSION['ins_orders'][$ins_order]['ins_type'])?>">
	<?php
	if ((int)$_SESSION['ins_orders'][$ins_order]['ins_type'] !== (int)$insuranseId) {
		$_SESSION['ins_orders'][$ins_order]['ins_type'] = $insuranseId;
	}
	?>
    <div id="insurance-accordion" role="tablist" aria-multiselectable="true">

        <!-- TAB 1 -->
        <div class="card card-current">
            <div class="card-header p-0" role="tab" id="headingOne">
                <h5 class="mb-0 text-5">
                    <a data-toggle="collapse" data-target="#collapseOne"
                       class="cursor-pointer d-flex align-items-center p-card"
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
                                           value="<?php echo $order_params !== false && !empty($order_params['order_details']['insurance_period']) ? $order_params['order_details']['insurance_period'] : ''; ?>"
                                           class="w-100 medium datepicker"/>


                                </div>

                                <div class="form-group mb-0 hidden-lg-up">

                                    <div class="datepicker static-datepicker"></div>

                                </div>

                            </div>

                            <div class="col">
								<?php
								$showPeriods = ($order_params !== false && (isset($order_params['order_details']['insurance-date-start']) && isset($order_params['order_details']['insurance-date-finish']))) ? '' : 'd-done';
								?>
                                <div class="insurance-date-finish-wrapper <?php echo $showPeriods;?>">
                                    <span class="text-5 color-6 normal ml-1">
									   <?php echo __( 'Insurance period', 'sogoc' ) . ': ' ?>
                                    </span>

                                    <input type="text" id="insurance-date-start" name="insurance-date-start"
                                           class="insurance-date-start text-5 d-inline color-3 bold text-center"
                                           value="<?php echo $order_params !== false ? trim($order_params['order_details']['insurance-date-start']) : ''; ?>" readonly/>
                                    <label for="insurance-date-start" class="sr-only">
										<?php echo $order_params !== false ? trim($order_params['order_details']['insurance-date-start']) : ''; ?>
                                    </label>
                                    <span class="color-3 js-seperator-line d-none">-</span>
                                    <input type="text" id="insurance-date-finish" name="insurance-date-finish"
                                           value="<?php echo $order_params !== false ? trim($order_params['order_details']['insurance-date-finish']) : ''; ?>"
                                           class="insurance-date-finish text-5 d-inline color-3 bold text-center" readonly/>
                                    <label for="insurance-date-finish" class="sr-only">
										<?php echo $order_params !== false ? trim($order_params['order_details']['insurance-date-start']) : ''; ?>
                                    </label>

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
        <div class="card">
            <div class="card-header p-0" role="tab" id="headingTwo">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center flex-wrap p-card" data-toggle="" data-parent="#insurance-accordion"
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
										if ($order_params === false) {
											sogo_do_select( __( 'Vehicle manufacturer', 'sogoc' ), 'vehicle-manufacturer',
												$vehicle_manufacturers, true, 1, 'text-to-header' );
										} else {
											sogo_do_select_filled( __( 'Vehicle manufacturer', 'sogoc' ), 'vehicle-manufacturer', $vehicle_manufacturers, 'text-to-header', $order_params['order_details']['vehicle-manufacturer'] );
										}
										?>

                                    </div>

                                    <!-- Vehicle year -->
                                    <div class="col-12 mb-2 mb-lg-3">

                                        <!-- tooltip -->
										<?php sogo_include_tooltip( 'vehicle-year', $help_array, __( 'Vehicle year', 'sogoc' ), $help_array['vehicle-year'] ); ?>

										<?php
										if ($order_params === false) {
											sogo_do_select( __( 'Vehicle year', 'sogoc' ), 'vehicle-year',
												array(), false, 1, 'text-to-header' );
										} else {
											$vehicle_years = sogo_get_manufacturer_years_filled( $order_params['order_details']['vehicle-manufacturer'] );
											sogo_do_select_filled( __( 'year', 'sogoc' ), 'vehicle-year', $vehicle_years, 'text-to-header', $order_params['order_details']['vehicle-year'] );
										}
										?>

                                    </div>

                                    <!-- Vehicle brand -->
                                    <div class="col-12 mb-2 mb-lg-3">
                                        <!-- tooltip -->
										<?php sogo_include_tooltip( 'vehicle-brand', $help_array, __( 'Vehicle brand', 'sogoc' ), $help_array['vehicle-brand'] ); ?>

										<?php
										if ($order_params === false) {
											//check if we have cookie, than take data from cookie
											sogo_do_select( __( 'Vehicle brand', 'sogoc' ), 'vehicle-brand', array(), false, 1, 'text-to-header' );
										} else {

											$models = sogo_get_models_filled( $order_params['order_details']['vehicle-manufacturer'], $order_params['order_details']['vehicle-year'] );

											sogo_do_select_filled( __( 'Vehicle brand', 'sogoc' ), 'vehicle-brand', $models, 'text-to-header', $order_params['order_details']['vehicle-brand'] );
										}
										?>

                                    </div>

                                    <!-- Vehicle sub brand -->
                                    <div class="col-12 mb-2 mb-lg-3">

                                        <!-- tooltip -->
										<?php sogo_include_tooltip( 'vehicle-sub-brand', $help_array, __( 'Vehicle sub brand', 'sogoc' ), $help_array['vehicle-sub-brand'] ); ?>

										<?php
										if ($order_params === false) {
											sogo_do_select( __( 'Vehicle sub brand', 'sogoc' ), 'vehicle-sub-brand', array() );
										} else {
											$sub_models = sogo_get_sub_models_filled( $order_params['order_details']['vehicle-manufacturer'], $order_params['order_details']['vehicle-year'], $order_params['order_details']['vehicle-brand'] );
											sogo_do_select_filled( __( 'Vehicle brand', 'sogoc' ), 'vehicle-sub-brand', $sub_models, '', $order_params['order_details']['vehicle-sub-brand'] );
										}
										?>

                                    </div>

                                </div>
                            </div>
                                        <input type="hidden" name="levi-code" class="d-none" id="levi-code" value="<?php echo ($order_params !== false ? $order_params['order_details']['levi-code'] : '' )?>"/>
                                        <input type="hidden" name="esp" class="d-none" id="esp" value="<?php echo $esp ?>"/>
                                        <input type="hidden" name="fcw" class="d-none" id="fcw" value="<?php echo $fcw ?>"/>
                                        <input type="hidden" name="ldw" class="d-none" id="ldw" value="<?php echo $ldw ?>"/>
                            <div class="col-lg-5">
                                <!-- row -->
                                <div class="row">

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
												if ($order_params !== false) {
													$check1 = $order_params['order_details']['keeping-distance-system'] == '1' ? 'checked' : '';
													$check2 = $order_params['order_details']['keeping-distance-system'] == '2' ? 'checked' : '';
												} else {
													$check1 = '';
													$check2 = '';
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
												if ($order_params !== false) {
													$check1 = $order_params['order_details']['deviation-system'] == '1' ? 'checked' : '';
													$check2 = $order_params['order_details']['deviation-system'] == '2' ? 'checked' : '';
												} else {
													$check1 = '';
													$check2 = '';
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
                                    <!-- Vehicle stability system from lane -->
                                    <div class="col-12 mb-2 mb-lg-3 stability-box <?php echo  (is_null($order_params['order_details']['stability-system']) ? ' d-none ' : ' ')?>">


                                        <div class="s-radio-wrapper">

                                            <!-- tooltip -->
											<?php sogo_include_tooltip( 'stability-system', $help_array, __( 'Is there stability system from lane', 'sogoc' ), $help_array['stability-system'] ); ?>

                                            <label class="text-5 color-6 d-inline-block mb-1">
												<?php _e( 'Is there stability system from lane', 'sogoc' ); ?>
                                            </label>

                                            <div class="d-flex">

												<?php

												if ($order_params !== false) {
													$check1 = $order_params['order_details']['stability-system'] == '1' ? 'checked' : '';
													$check2 = $order_params['order_details']['stability-system'] == '2' ? 'checked' : '';
												} else {
													$check1 = '';
													$check2 = '';
												}

												?>

                                                <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                                       name="stability-system" id="stability-system-1" value="1"
                                                       data-val="yes" <?php echo $check1; ?>>
                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                       for="stability-system-1">
													<?php _e( 'Yes', 'sogoc' ); ?>
                                                </label>

                                                <input type="radio" class="form-radio-input opacity-0"
                                                       name="stability-system" id="stability-system-2" value="2"
                                                       data-val="no" <?php echo $check2; ?>>
                                                <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                       for="stability-system-2">
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
        <div class="card">
            <div class="card-header p-0" role="tab" id="headingThree">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center flex-wrap p-card" data-toggle="" data-parent="#insurance-accordion"
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

										if ( $order_params === false) {
											sogo_do_select( __( 'Youngest driver\'s age', 'sogoc' ), 'youngest-driver',
												$ages, false, $min_age, 'text-to-header' );
										} else {
											sogo_do_select_filled( __( 'Youngest driver\'s age', 'sogoc' ), 'youngest-driver', $ages, 'text-to-header', $order_params['order_details']['youngest-driver'] );
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

										if ( $order_params === false) {
											sogo_do_select( __( 'Lowest driving seniority', 'sogoc' ), 'lowest-seniority', $seniority, false, $min_seniority, 'text-to-header' );
										} else {
											sogo_do_select_filled( __( 'Lowest driving seniority', 'sogoc' ), 'lowest-seniority', $seniority, 'text-to-header', $order_params['order_details']['lowest-seniority'] );
										}
										?>

                                    </div>
                               </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="row">
									  <!-- Number of people allowed to drive in vehicle -->
									  <!-- sami -->
									<div class="col-lg-12 mb-3">

                                <div class="s-radio-wrapper">

                                    <!-- tooltip -->
									<?php sogo_include_tooltip( 'drive-allowed-number', $help_array, __( 'Number allowed to drive', 'sogoc' ), $help_array['drive-allowed-number'] );  ?>

                                    <label class="text-5 color-6 d-inline-block mb-1">
									<?php if($insurance_type != 'HOVA') _e( 'Number allowed to drive', 'sogoc' ); else echo 'מספר הנהגים (בביטוח חובה יש לבחור כל נהג)'; ?>
                                    </label>

                                    <div class="d-flex">

										<?php
										if ($order_params !== false) {
											$check1 = $order_params['order_details']['drive-allowed-number'] == '1' ? 'checked' : '';
											$check2 = $order_params['order_details']['drive-allowed-number'] == '2' ? 'checked' : '';
											$check3 = $order_params['order_details']['drive-allowed-number'] == '3' ? 'checked' : '';
											$check4 = $order_params['order_details']['drive-allowed-number'] == '4' ? 'checked' : '';
										} else {
											$check1 = '';
											$check2 = '';
											$check3 = '';
											$check4 = '';
										}
										?>

                                        <input type="radio" class="form-radio-input opacity-0 d-none"
                                               name="drive-allowed-number" id="drive-allowed-number-1" value="1"
                                               <?php echo $check1; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="drive-allowed-number-1">
נהג יחיד                                        </label>

                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="drive-allowed-number" id="drive-allowed-number-2" value="2"
                                               <?php echo $check2; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="drive-allowed-number-2">
2 נהגים                                        </label>

                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="drive-allowed-number" id="drive-allowed-number-3" value="3"
                                               <?php echo $check4; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="drive-allowed-number-3">
3 נהגים                                        </label>
                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="drive-allowed-number" id="drive-allowed-number-4" value="4"
                                               <?php echo $check4; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="drive-allowed-number-4">
כל נהג                                        </label>
                                    </div>

                                </div>

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
												if ( $order_params !== false) {
													$check1 = $order_params['order_details']['gender'] == '1' ? 'checked' : '';
													$check2 = $order_params['order_details']['gender'] == '2' ? 'checked' : '';
												} else {
													$check1 = '';
													$check2 = '';
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
					<!-- Drive on saturday -->
                            <div class="col-lg-12 mb-3">

                                <div class="s-radio-wrapper">

                                    <!-- tooltip -->
									<?php sogo_include_tooltip( 'drive-on-saturday', $help_array, __( 'Drive on saturday', 'sogoc' ), $help_array['drive-on-saturday'] ); ?>

                                    <label class="text-5 color-6 d-inline-block mb-1">
										<?php _e( 'Drive on saturday', 'sogoc' ); ?>
                                    </label>

                                    <div class="d-flex">

										<?php
										if ($order_params !== false) {
											$check1 = $order_params['order_details']['drive-on-saturday'] == '1' ? 'checked' : '';
											$check2 = $order_params['order_details']['drive-on-saturday'] == '2' ? 'checked' : '';
										} else {
											$check1 = '';
											$check2 = '';
										}
										?>

                                        <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                               name="drive-on-saturday" id="drive-on-saturday-1" value="1"
                                               data-val="yes" <?php echo $check1; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="drive-on-saturday-1">
											<?php _e( 'Yes', 'sogoc' ); ?>
                                        </label>

                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="drive-on-saturday" id="drive-on-saturday-2" value="2"
                                               data-val="no" <?php echo $check2; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="drive-on-saturday-2">
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
        <!-- TAB 4 -->
        <div class="card">
            <div class="card-header p-0" role="tab" id="headingFour">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center flex-wrap p-card" data-toggle="" data-parent="#insurance-accordion"
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
										if ( $order_params !== false) {
											$check1 = $order_params['order_details']['insurance-before'] == '1' ? 'checked' : '';
											$check2 = $order_params['order_details']['insurance-before'] == '2' ? 'checked' : '';
										} else {
											$check1 = '';
											$check2 = '';
										}

										?>

                                        <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                               name="insurance-before" id="insurance-before-1" value="1"
                                               data-val="yes" <?php echo $check1; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="insurance-before-1">
											<?php _e( 'Yes', 'sogoc' ); ?>
                                        </label>

                                        <input onchange="sami_clear_insurance_before_years()" type="radio" class="form-radio-input opacity-0"
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
                            <div class="col-lg-5">
                                <!-- Insurance a year ago -->
                            <div class="w-100 mb-3">

                                <div class="s-radio-wrapper">

                                    <!-- tooltip -->
									<?php sogo_include_tooltip( 'insurance-1-year', $help_array, __( 'insurance-1-year', 'sogoc' ), $help_array['insurance-1-year'] ); ?>

                                    <label class="text-5 color-6 d-inline-block mb-1">
										סוג ביטוח לפני שנה
                                    </label>

                                    <div class="d-flex">

										<?php
										if ($order_params !== false) {
											$check1 = $order_params['order_details']['insurance-1-year'] == '1' ? 'checked' : '';
											$check2 = $order_params['order_details']['insurance-1-year'] == '2' ? 'checked' : '';
											$check3 = $order_params['order_details']['insurance-1-year'] == '3' ? 'checked' : '';
										} else {
											$check1 = '';
											$check2 = '';
											$check3 = '';

										}
										?>

                                        <input onchange="sami_claims_info()" type="radio" class="form-radio-input opacity-0 p-absolute"
                                               name="insurance-1-year" id="insurance-1-year-1" value="1"
                                               <?php echo $check1; ?>>
                                        <label onclick="sami_claims_info()" class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="insurance-1-year-1">
מקיף                                        </label>

                                        <input onclick="sami_claims_info()" type="radio" class="form-radio-input opacity-0"
                                               name="insurance-1-year" id="insurance-1-year-2" value="2"
                                               <?php echo $check2; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="insurance-1-year-2">
צד ג                                        </label>

                                        <input onclick="sami_claims_info()" type="radio" class="form-radio-input opacity-0"
                                               name="insurance-1-year" id="insurance-1-year-3" value="3"
                                               <?php echo $check3; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="insurance-1-year-3">
לא היה                                        </label>

                                    </div>

                                </div>

                            </div>

                                <!-- Insurance two years ago -->
                            <div class="w-100 mb-3">

                                <div class="s-radio-wrapper">

                                    <!-- tooltip -->
									<?php sogo_include_tooltip( 'insurance-2-year', $help_array, __( 'insurance-2-year', 'sogoc' ), $help_array['insurance-2-year'] ); ?>

                                    <label class="text-5 color-6 d-inline-block mb-1">
										סוג ביטוח לפני שנתיים
                                    </label>

                                    <div class="d-flex">

										<?php
										if ($order_params !== false) {
											$check1 = $order_params['order_details']['insurance-2-year'] == '1' ? 'checked' : '';
											$check2 = $order_params['order_details']['insurance-2-year'] == '2' ? 'checked' : '';
											$check3 = $order_params['order_details']['insurance-2-year'] == '3' ? 'checked' : '';
										} else {
											$check1 = '';
											$check2 = '';
											$check3 = '';

										}
										?>

                                        <input onclick="sami_claims_info()" type="radio" class="form-radio-input opacity-0 p-absolute"
                                               name="insurance-2-year" id="insurance-2-year-1" value="1"
                                               <?php echo $check1; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="insurance-2-year-1">
מקיף                                        </label>

                                        <input onclick="sami_claims_info()" type="radio" class="form-radio-input opacity-0"
                                               name="insurance-2-year" id="insurance-2-year-2" value="2"
                                               <?php echo $check2; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="insurance-2-year-2">
צד ג                                        </label>

                                        <input onclick="sami_claims_info()" type="radio" class="form-radio-input opacity-0"
                                               name="insurance-2-year" id="insurance-2-year-3" value="3"
                                               <?php echo $check3; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="insurance-2-year-3">
לא היה                                        </label>

                                    </div>

                                </div>

                            </div>

                                <!-- Insurance three years ago -->
                            <div class="w-100 mb-3">

                                <div class="s-radio-wrapper">

                                    <!-- tooltip -->
									<?php sogo_include_tooltip( 'insurance-3-year', $help_array, __( 'insurance-3-year', 'sogoc' ), $help_array['insurance-3-year'] ); ?>

                                    <label class="text-5 color-6 d-inline-block mb-1">
										סוג ביטוח לפני 3 שנים
                                    </label>

                                    <div class="d-flex">

										<?php
										if ($order_params !== false) {
											$check1 = $order_params['order_details']['insurance-3-year'] == '1' ? 'checked' : '';
											$check2 = $order_params['order_details']['insurance-3-year'] == '2' ? 'checked' : '';
											$check3 = $order_params['order_details']['insurance-3-year'] == '3' ? 'checked' : '';
										} else {
											$check1 = '';
											$check2 = '';
											$check3 = '';

										}
										?>

                                        <input onclick="sami_claims_info()" type="radio" class="form-radio-input opacity-0 p-absolute"
                                               name="insurance-3-year" id="insurance-3-year-1" value="1"
                                               <?php echo $check1; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="insurance-3-year-1">
מקיף                                        </label>

                                        <input onclick="sami_claims_info()" type="radio" class="form-radio-input opacity-0"
                                               name="insurance-3-year" id="insurance-3-year-2" value="2"
                                               <?php echo $check2; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="insurance-3-year-2">
צד ג                                        </label>

                                        <input onclick="sami_claims_info()" type="radio" class="form-radio-input opacity-0"
                                               name="insurance-3-year" id="insurance-3-year-3" value="3"
                                               <?php echo $check3; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="insurance-3-year-3">
לא היה                                        </label>

                                    </div>

                                </div>

                            </div>
                            </div>
                            <div class="col-lg-5">

                                <!-- Did you had law suites in last 3 years -->
                            <div class="w-100 mb-3">

                                    <!-- tooltip -->
									<?php sogo_include_tooltip( 'law-suites-3-year', $help_array, __( 'Did you had law suites in last 3 years', 'sogoc' ), $help_array['law-suites-3-year'] ); ?>

									<?php

									//		                            echo '<pre style="direction: ltr;">';
									//		                            var_dump($order_params['order_details']['law-suites-3-year']);
									//		                            echo '</pre>';

									if ( $order_params === false) {
										sogo_do_select( __( 'Did you had law suites in last 3 years', 'sogoc' ), 'law-suites-3-year',
											array(
												'לא היו',
												'תביעה 1',
												'2 ומעלה'
											), false, 0 );
									} else {
										sogo_do_select_filled_key( __( 'Did you had law suites in last 3 years', 'sogoc' ), 'law-suites-3-year', array(
											'לא היו',
											'תביעה 1',
											'2 ומעלה'
										), '', $order_params['order_details']['law-suites-3-year'], true );
									}
									?>

                                </div>
								<?php
								$class = ' d-none ';

								if ( $order_params !== false && (int)$order_params['order_details']['law-suites-3-year'] === 1) {
									$class = '';
								}
								?>
                                <!-- What year was the law suite -->
                                <div id="law-suits" class="w-100 mb-3  <?php echo $class;?>">

                                    <!-- tooltip -->
									<?php sogo_include_tooltip( 'law-suite-what-year', $help_array, __( 'What year was the law suite', 'sogoc' ), $help_array['law-suite-what-year'] ); ?>

									<?php
									if ($order_params === false) {
										sogo_do_select( __( 'What year was the law suite', 'sogoc' ), 'law-suite-what-year',
											array(
												'שנה אחרונה',
												'לפני שנתיים',
												'לפני שלוש שנים'
											), false, 1 );
									} else {
										sogo_do_select_filled_key( __( 'What year was the law suite', 'sogoc' ), 'law-suite-what-year', array(
											'שנה אחרונה',
											'לפני שנתיים',
											'לפני שלוש שנים'
										), '', $order_params['order_details']['law-suite-what-year'] );
									}
									?>

                                </div>

                            </div>


                        </div>
                        <!-- ROW -->
                        <div class="row justify-content-between">


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
            <div class="card-header p-0" role="tab" id="headingFive">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center p-card" data-toggle="" data-parent="#insurance-accordion"
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

                            <div class="col-lg-5">
                                <div class="row">
                                    <!-- Vehicle ownership -->
                            <div class="col-lg-12 mb-3">

                                        <div class="s-radio-wrapper">

                                            <!-- tooltip -->
											<?php sogo_include_tooltip( 'ownership', $help_array, __( 'Vehicle ownership', 'sogoc' ), $help_array['ownership'] ); ?>

                                            <label class="text-5 color-6 d-inline-block mb-1">
												<?php _e( 'Vehicle ownership', 'sogoc' ); ?>
                                            </label>

                                            <div class="d-flex">

												<?php
												if ($order_params !== false) {
													$check1 = $order_params['order_details']['ownership'] == '1' ? 'checked' : '';
													$check2 = $order_params['order_details']['ownership'] == '2' ? 'checked' : '';
												} else {
													$check1 = '';
													$check2 = '';
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

                                    </div>
                                                                <!-- License suspensions -->
                            <div class="col-lg-12 mb-3">

                                <div class="s-radio-wrapper">

                                    <!-- tooltip -->
									<?php sogo_include_tooltip( 'license-suspensions', $help_array, __( 'license-suspensions', 'sogoc' ), $help_array['license-suspensions'] ); ?>

                                    <label class="text-5 color-6 d-inline-block mb-1">
סה"כ שלילות רשיון ב 3 שנים אחרונות                                    </label>

                                    <div class="d-flex">

										<?php
										if ($order_params !== false) {
											$check1 = $order_params['order_details']['license-suspensions'] == '0' ? 'checked' : '';
											$check2 = $order_params['order_details']['license-suspensions'] == '1' ? 'checked' : '';
											$check3 = $order_params['order_details']['license-suspensions'] == '2' ? 'checked' : '';
										} else {
											$check1 = '';
											$check2 = '';
											$check3 = '';

										}
										?>

                                        <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                               name="license-suspensions" id="license-suspensions-0" value="0"
                                               <?php echo $check1; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="license-suspensions-0">
0                                        </label>

                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="license-suspensions" id="license-suspensions-1" value="1"
                                               <?php echo $check2; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="license-suspensions-1">
1                                        </label>

                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="license-suspensions" id="license-suspensions-2" value="2"
                                               <?php echo $check3; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="license-suspensions-2">
2+                                        </label>

                                    </div>

                                </div>

                            </div>
                            <!-- Where there body claims -->
                            <div class="col-lg-12 mb-3">

                                <div class="s-radio-wrapper">

                                    <!-- tooltip -->
									<?php sogo_include_tooltip( 'body-claims', $help_array, __( 'body-claims', 'sogoc' ), $help_array['body-claims'] ); ?>

                                    <label class="text-5 color-6 d-inline-block mb-1">
סה"כ תביעות גוף ב 3 שנים אחרונות
                                    </label>

                                    <div class="d-flex">

										<?php
										if ($order_params !== false) {
											$check1 = $order_params['order_details']['body-claims'] == '1' ? 'checked' : '';
											$check2 = $order_params['order_details']['body-claims'] == '2' ? 'checked' : '';
											$check3 = $order_params['order_details']['body-claims'] == '3' ? 'checked' : '';
										} else {
											$check1 = '';
											$check2 = '';
											$check3 = '';

										}
										?>

                                        <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                               name="body-claims" id="body-claims-1" value="1"
                                               <?php echo $check1; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="body-claims-1">
0                                        </label>

                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="body-claims" id="body-claims-2" value="2"
                                               <?php echo $check2; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="body-claims-2">
1                                        </label>

                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="body-claims" id="body-claims-3" value="3"
                                               <?php echo $check3; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="body-claims-3">
2+                                        </label>

                                    </div>

                                </div>

                            </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
                                <div class="row">
								<!-- City -->
                            <div class="col-lg-12 s-input-wrapper mt-3">
                                <div class="form-group">

                                    <label for="city" class="text-5 color-6 d-block mb-1"><?php echo __( 'City of residence', 'sogoc' ) ?></label>

                                    <input  type="text" id="city" name="city" class="w-100" value="<?php echo $order_params !== false ? $order_params['order_details']['city'] : '';?>" />

                                </div>
                            </div>

                            <div class="col-lg-12 mb-3 s-input-wrapper <?php if($insurance_type == 'HOVA' || $insurance_type == 'ZAD_G' ) echo 'd-none';?>">

		                        <?php if ( array_key_exists( 'license_no', $help_array ) ): ?>
                                    <!--                                    <span class="info-help">-->
                                    <!--                                            --><?php //echo $help_array['license_no']; ?>
                                    <!--                                        </span>-->
			                        <?php sogo_include_tooltip( 'license_no', $help_array, __( 'License number go', 'sogoc' ), $help_array['license_no'] ); ?>

		                        <?php endif; ?>

                                <label for="license_no"
                                       class="text-5 color-6 d-inline-block mb-1"><?php echo __( 'License number go', 'sogoc' ); ?></label>

                                <input type="number"
                                       maxlength="8"
									   minlength="7"
                                       data-year="<?php echo $order_params ['order_details']['vehicle-year'] ?>"
                                       id="license_no"
                                       name="license_no" class="w-100"
                                       value="<?php echo $order_params !== false ? $order_params['order_details']['license_no'] : '';?>" />

                            </div>
                        </div>

                    </div>

                </div>
                <!-- CONTAINER-FLUID -->
                <div class="container-fluid mb-3">
					                        <div class="row">
                            <!-- Terms & conditions 1 -->
                            <div class="col-lg-12">

                                <div class="form-group">

                                    <input type="checkbox"
                                           name="tac"
                                           class="form-control tac-1 opacity-0"
                                           id="tac"/>
									<?php if ( array_key_exists( 'tac-1', $help_array ) ): ?>
                                        <span class="info-help">
                                            <?php echo $help_array['tac-1']; ?>
                                        </span>
									<?php endif; ?>

                                    <label for="tac" class="d-flex align-items-center checkbox-label text-6 color-6 flex-wrap">

                                        <span class="font-09em"><?php _e( 'Agree to the using condition', 'sogoc' ); ?></span>
                                        -
                                        <span>
									<a target="_blank"
                                                 href="<?php the_field( '_sogo_site_tac', 'option' );?>"
                                                 class="underline"><?php _e( 'to site terms', 'sogoc' ); ?></a></span>

                                    </label>

                                </div>

                                <!-- hidden fields -->
                                <input type="text" name="insurance-type" class="d-none"
                                       value="<?php echo $insurance_type; ?>"/>

                            </div>
                        </div>
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
    </div>    </div>

</form>
