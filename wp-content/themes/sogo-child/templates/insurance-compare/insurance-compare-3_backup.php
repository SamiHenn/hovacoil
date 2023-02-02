<?php

$ins_order = ( isset( $_GET['ins_order'] ) ? trim( strip_tags( $_GET['ins_order'] ) ) : '' );
$ins_type  = ( isset( $_GET['i_type'] ) ? trim( strip_tags( $_GET['i_type'] ) ) : '' );
$fromCrm   = ( isset( $_GET['s'] ) ? trim( strip_tags( $_GET['s'] ) ) : '' );

$help_array = array();

$info_rows = get_field( '_sogo_info_help', 'option' );

foreach ( $info_rows as $row ) {
	$help_array[ $row['name'] ] = $row['text'];
}

echo '<pre style="direction: ltr;">';
var_dump($order_params);
echo '</pre>';
//echo '<pre style="direction: ltr;">';
//var_dump(urldecode(add_query_arg( 'insurance-type', $_GET['insurance-type'], get_permalink( get_field( '_sogo_insurance_compare_2_link', 'option' ) ))));
//echo '</pre>';
?>

<form action="<?php echo add_query_arg( 'insurance-type', $_GET['insurance-type'], get_permalink( get_field( '_sogo_insurance_compare_2_link', 'option' ) ) ); ?>"
      method="post"
      id="form-2">
    <input name="ins_link" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">

	<?php if ( isset( $_GET['i_type'] ) && ! empty( $_GET['i_type'] ) ) : ?>
        <input name="ins-type" type="hidden" value="<?php echo $ins_type ?>">
	<?php endif; ?>

	<?php if ( isset( $_GET['s'] ) && ! empty( $_GET['s'] ) && $_GET['s'] == 1 ) : ?>
        <input name="source-srm" type="hidden" value="<?php echo $fromCrm; ?>"/>
	<?php endif; ?>

	<?php if ( isset( $_GET['ins_order'] ) && ! empty( $_GET['ins_order'] ) ) : ?>
        <input name="ins-order" type="hidden" value="<?php echo $ins_order; ?>"/>
	<?php endif; ?>

    <div id="insurance-accordion" role="tablist" aria-multiselectable="true">

        <!-- TAB 1 -->
        <div class="card card-current">
            <div class="card-header p-0" role="tab" id="headingOne">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center flex-wrap p-card" data-toggle="collapse"
                       data-parent="#insurance-accordion"
                       href="#collapseOne"
                       aria-expanded="false" aria-controls="collapseOne">

                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

						<?php echo __( 'Completion of vehicle details', 'sogoc' ) . '  '; ?>

                        <div class="d-flex flex-wrap selected-header-box"></div>

                    </a>
                </h5>
            </div>
            <div id="collapseOne" class="collapse content-top show" role="tabpanel" aria-labelledby="headingOne">
                <div class="card-block mb-3">

                    <!-- CONTAINER-FLUID -->
                    <div class="container-fluid">
						<?php
						//echo '<pre style="direction: ltr;">';
						//var_dump($order_params);
						//echo '</pre>';

						?>
                        <!-- ROW -->
                        <div class="row justify-content-between">

                            <div class="col-lg-5 mb-3 s-input-wrapper">

                                <label for="license-number"
                                       class="text-5 color-6 d-block mb-1"><?php echo __( 'License number', 'sogoc' ); ?></label>

                                <input type="text"
                                       data-year="<?php echo $order_params['order_params']['vehicle-year'] ?>"
                                       id="license-number"
                                       name="license-number"
                                       class="w-100"
                                       value="<?php echo( isset( $order_params['license-number'] ) ? $order_params['license-number'] : '' ) ?>"/>

								<?php if ( array_key_exists( 'license-number', $help_array ) ): ?>
                                    <span class="info-help">
                                            <?php echo $help_array['license-number']; ?>
                                        </span>
								<?php endif; ?>
                            </div>

                            <!-- Vehicle license number -->
							<?php
							//							sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'license-number', __( 'License number', 'sogoc' ), 'text' );
							?>

                            <!-- Vehicle manufacturer -->
                            <div class="col-lg-5 mb-3">

                                <div class="s-radio-wrapper">

                                    <label class="text-5 color-6 d-block mb-1">
										<?php _e( 'Ownership date', 'sogoc' ); ?>
                                    </label>

                                    <div class="d-flex">

                                        <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                               name="ownership-date"
                                               checked="<?php echo( isset( $order_params['ownership-date'] ) && $order_params['ownership-date'] === '1' ? 'checked' : '' ) ?>"
                                               id="ownership-date-1" value="1"
                                               data-val="under-year">
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="ownership-date-1">
											<?php _e( 'Under a year', 'sogoc' ); ?>
                                        </label>

                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="ownership-date"
                                               checked="<?php echo( isset( $order_params['ownership-date'] ) && $order_params['ownership-date'] === '2' ? 'checked' : '' ) ?>"
                                               id="ownership-date-2" value="2"
                                               data-val="above-year">
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="ownership-date-2">
											<?php _e( 'Above a year', 'sogoc' ); ?>
                                        </label>

                                    </div>

                                </div>

								<?php if ( array_key_exists( 'ownership-date', $help_array ) ): ?>
                                    <span class="info-help">
                                            <?php echo $help_array['ownership-date']; ?>
                                        </span>
								<?php endif; ?>
                            </div>

                            <!-- Choose car ownership date -->
                            <div class="col-lg-5 s-input-wrapper under <?php echo( isset( $order_params['ownership-date'] ) && $order_params['ownership-date'] == 1 ? '' : 'd-none' ) ?>">

                                <label class="text-5 color-6"><?php _e( 'Choose car ownership car date', 'sogoc' ); ?></label>

                                <div class="form-group date-picker mb-0 hidden-lg-down">
                                    <input type="text"
                                           value="<? echo( isset( $order_params['ownership-date'] ) && $order_params['ownership-date'] === '1' ? $order_params['ownership-under-year'] : '' ) ?>"
                                           readonly="readonly" name="ownership-under-year"
                                           class="w-100 medium under-year"/>
                                </div>

                                <div class="form-group mb-0 hidden-lg-up">

                                    <div class="under-year static-datepicker"></div>

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
                    <a class="collapsed d-flex align-items-center flex-wrap p-card" data-toggle=""
                       data-parent="#insurance-accordion"
                       href="#collapseTwo"
                       aria-expanded="false" aria-controls="collapseTwo">

                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

						<?php echo __( 'Details of the policyholder', 'sogoc' ) . '  '; ?>

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

                            <div class="col-md-5">
                                <!-- First name -->
								<?php
								sogo_do_input(
									'mb-3 s-input-wrapper',
									'first-name',
									__( 'First name', 'sogoc' ),
									'text',
									'',
									isset( $order_params['first-name'] ) && ! is_array( $order_params['first-name'] ) ?
										$order_params['first-name'] : isset( $order_params['first-name'] ) && is_array( $order_params['first-name'] ) ?
										$order_params['first-name'][0] : ''
								);
								?>
								<?php if ( array_key_exists( 'first-name', $help_array ) ): ?>
                                    <span class="info-help">
                                            <?php echo $help_array['first-name']; ?>
                                        </span>
								<?php endif; ?>


                                <!-- Last name -->
								<?php
								sogo_do_input(
									'mb-3 s-input-wrapper',
									'last-name',
									__( 'Last name', 'sogoc' ),
									'text',
									'',
									isset( $order_params['last-name'] ) && ! is_array( $order_params['last-name'] ) ?
										$order_params['last-name'] : isset( $order_params['last-name'] ) && is_array( $order_params['first-name'] ) ?
										$order_params['last-name'][0] : ''
								);
								?>
								<?php if ( array_key_exists( 'last-name', $help_array ) ): ?>
                                    <span class="info-help">
                                            <?php echo $help_array['last-name']; ?>
                                        </span>
								<?php endif; ?>


                                <!-- Identical number (ID) -->
								<?php
								sogo_do_input(
									'mb-3 s-input-wrapper',
									'identical-number',
									__( 'Identical number', 'sogoc' ),
									'text',
									'',
									isset( $order_params['identical-number'] ) && ! is_array( $order_params['identical-number'] ) ?
										$order_params['identical-number'] : isset( $order_params['identical-number'] ) && is_array( $order_params['identical-number'] ) ?
										$order_params['identical-number'][0] : ''
								);
								?>
								<?php if ( array_key_exists( 'identical-number', $help_array ) ): ?>
                                    <span class="info-help">
                                            <?php echo $help_array['identical-number']; ?>
                                        </span>
								<?php endif; ?>


                                <!-- Drive license year -->

                                <!--<div class="col-lg-5 mb-3 s-input-wrapper license-box">

                                <label for="license-year" class="text-5 color-6 d-block mb-1"><?php /*echo _e( 'Year of issuing a license', 'sogoc' ); */ ?></label>

                                <input data-young-driver="<?php /*echo $order_params['youngest-driver']*/ ?>" data-seniority="<?php /*echo $order_params['order_details']['lowest-seniority']*/ ?>" type="text" id="license-year" name="license-year" class="w-100" value="" />

                            </div>-->


								<?php
								$current_time          = new DateTime( 'now', $time_zone );
								$curr_year             = (int) $current_time->format( 'Y' );
								$seniority             = (int) $order_params['order_details']['lowest-seniority'];
								$max_year_by_seniority = $curr_year - $seniority;
								//                            sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper license-box', 'license-year', __( 'Year of issuing a license', 'sogoc' ), 'text', '' );
								//								sogo_do_select( __( 'Year of issuing a license', 'sogoc' ), 'license-year', $license_year );
								?>
                                <div class="s-input-wrapper mb-3">
									<?php
									$time_zone       = new DateTimeZone( 'Asia/Jerusalem' );
									$insurance_start = DateTime::createFromFormat( 'd/m/Y', $order_params['order_details']['insurance_period'], $time_zone );
									$date_dif        = DateTime::createFromFormat( 'd/m/Y', $order_params['order_details']['insurance_period'], $time_zone );

									$can_choose_birthday = $insurance_start->modify( '-' . $order_params['order_details']['youngest-driver'] . 'year' );

									$start_birthday = $can_choose_birthday->diff( $date_dif )->days;
									?>

                                    <label class="text-5 color-6"><?php _e( 'Birthday', 'sogoc' ); ?></label>
                                    <div class="form-group date-picker mb-0 hidden-lg-down">
                                        <input type="text" readonly="readonly" name="birthday-date"
                                               data-start="<?php echo $start_birthday; ?>"
                                               class="w-100 medium birthday-date datepicker"
                                               value="<?php echo isset( $order_params['birthday-date'] ) ? $order_params['birthday-date'] : '' ?>"
                                        />
                                    </div>

                                    <div class="form-group mb-0 hidden-lg-up">

                                        <div class="birthday-date static-datepicker"></div>

                                    </div>
									<?php if ( array_key_exists( 'birthday-date', $help_array ) ): ?>
                                        <span class="info-help">
                                            <?php echo $help_array['birthday-date']; ?>
                                        </span>
									<?php endif; ?>
                                </div>
                                <div class="mb-3 license-box <?php echo isset( $order_params['drive-allowed'] ) && $order_params['drive-allowed'] === '2' ? ' d-none' : '' ?>">
                                    <label for="license-year"
                                           class="text-5 color-6 d-block mb-1"><?php echo _e( 'Year of issuing a license', 'sogoc' ); ?></label>

                                    <div class="s-select-wrapper ">
                                        <input type="hidden" readonly id="tmp_license_year"
                                               value="<?php echo isset( $order_params['license-year'] ) ? $order_params['license-year'] : '' ?>"
											<?php echo isset( $order_params['drive-allowed'] ) && $order_params['drive-allowed'] === '2' ? ' disabled' : '' ?>
                                        >
                                        <select name="license-year" id="license-year"
                                                data-max-year="<?php echo $max_year_by_seniority; ?>"
											<?php echo isset( $order_params['drive-allowed'] ) && $order_params['drive-allowed'] === '2' ? ' disabled' : '' ?>
                                        >

                                            <option value="">בחר</option>
                                        </select>

                                    </div>
                                </div>
								<?php if ( array_key_exists( 'license-year', $help_array ) && ( isset( $order_params['drive-allowed'] ) && $order_params['drive-allowed'] === '1' ) ): ?>
                                    <span class="info-help">
                                    <?php echo $help_array['license-year']; ?>
                                </span>
								<?php endif; ?>

                            </div>

                            <div class="col-md-2"></div>


                            <div class="col-md-5">
                                <!-- Choose birth date -->


                                <!-- Youngest insurance gender -->
                                <div class="mb-3 s-input-wrapper">

                                    <div class="s-radio-wrapper">

                                        <label class="text-5 color-6 d-block mb-1">
											<?php _e( 'Youngest driver\'s gender', 'sogoc' ); ?>
                                        </label>

                                        <div class="d-flex">

                                            <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                                   name="gender" id="gender-1" value="1"
                                                   checked="<?php echo( isset( $order_params['gender'] ) && $order_params['gender'] === '1' ? 'checked' : '' ) ?>"
                                                   data-val="male">
                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                   for="gender-1">
												<?php _e( 'Male', 'sogoc' ); ?>
                                            </label>

                                            <input type="radio" class="form-radio-input opacity-0"
                                                   name="gender" id="gender-2" value="2"
                                                   data-val="female">
                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                   checked="<?php echo( isset( $order_params['gender'] ) && $order_params['gender'] === '2' ? 'checked' : '' ) ?>"
                                                   for="gender-2">
												<?php _e( 'Female', 'sogoc' ); ?>
                                            </label>

                                        </div>

                                    </div>

									<?php if ( array_key_exists( 'gender', $help_array ) ): ?>
                                        <span class="info-help">
                                            <?php echo $help_array['gender']; ?>
                                        </span>
									<?php endif; ?>
                                </div>


                                <!-- Drive allowed number -->
                                <div class="mb-3 s-input-wrapper">

                                    <div class="s-radio-wrapper">

                                        <label class="text-5 color-6 d-block mb-1">
											<?php _e( 'Is the policyholder one of the drivers in the vehicle?', 'sogoc' ); ?>
                                        </label>

                                        <div class="d-flex"
                                             data-allowed="<?php echo $order_params['order_details']['drive-allowed-number']; ?>">

                                            <input type="radio"
                                                   class="form-radio-input opacity-0 p-absolute drive-allowed"
                                                   name="drive-allowed" id="drive-allowed-1" value="1"
												<?php echo( isset( $order_params['drive-allowed'] ) && $order_params['drive-allowed'] === '1' ? 'checked' : '' ) ?>
                                                   data-val="yes">
                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                   for="drive-allowed-1">
												<?php _e( 'Yes', 'sogoc' ); ?>
                                            </label>

                                            <input type="radio" class="form-radio-input opacity-0 drive-allowed"
                                                   name="drive-allowed" id="drive-allowed-2" value="2"
												<?php echo( isset( $order_params['drive-allowed'] ) && $order_params['drive-allowed'] === '2' ? 'checked' : '' ) ?>
                                                   data-val="no">
                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                   for="drive-allowed-2">
												<?php _e( 'No', 'sogoc' ); ?>
                                            </label>
                                        </div>

                                    </div>

									<?php if ( array_key_exists( 'drive-allowed', $help_array ) ): ?>
                                        <span class="info-help">
                                            <?php echo $help_array['drive-allowed']; ?>
                                        </span>
									<?php endif; ?>
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
        <div class="card third-box">
            <div class="card-header p-0" role="tab" id="headingThree">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center flex-wrap p-card" data-toggle=""
                       data-parent="#insurance-accordion"
                       href="#collapseThree"
                       aria-expanded="false" aria-controls="collapseThree">

                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

						<?php _e( 'Contact info', 'sogoc' ); ?>

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

                            <!-- Mobile phone number -->
							<?php
							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'mobile-phone-number',
								__( 'Mobile phone', 'sogoc' ), 'text',
								'',
								isset( $order_params['mobile-phone-number'] ) && ! is_array( $order_params['mobile-phone-number'] ) ?
									$order_params['mobile-phone-number'] : isset( $order_params['mobile-phone-number'] ) && is_array( $order_params['mobile-phone-number'] ) ?
									$order_params['mobile-phone-number'][0] : ''
							);
							?>
							<?php if ( array_key_exists( 'mobile-phone-number', $help_array ) ): ?>
                                <span class="info-help">
                                            <?php echo $help_array['mobile-phone-number']; ?>
                                        </span>
							<?php endif; ?>

                            <!-- Email -->
							<?php
							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'email', __( 'Email', 'sogoc' ),
								'text',
								'',
								isset( $order_params['email'] ) && ! is_array( $order_params['email'] ) ?
									$order_params['email'] : isset( $order_params['email'] ) && is_array( $order_params['email'] ) ?
									$order_params['email'][0] : ''
							);
							?>
							<?php if ( array_key_exists( 'email', $help_array ) ): ?>
                                <span class="info-help">
                                            <?php echo $help_array['email']; ?>
                                        </span>
							<?php endif; ?>

                            <!-- Additional phone number -->
							<?php
							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'additional-phone-number',
								__( 'Additional phone', 'sogoc' ),
								'text',
								'',
								isset( $order_params['additional-phone-number'] ) && ! is_array( $order_params['additional-phone-number'] ) ?
									$order_params['additional-phone-number'] : isset( $order_params['additional-phone-number'] ) && is_array( $order_params['additional-phone-number'] ) ?
									$order_params['additional-phone-number'][0] : ''
							);
							?>
							<?php if ( array_key_exists( 'additional-phone-number', $help_array ) ): ?>
                                <span class="info-help">
                                            <?php echo $help_array['additional-phone-number']; ?>
                                        </span>
							<?php endif; ?>

                            <!-- City -->
							<?php
							sogo_do_input_2( 'col-lg-5 mb-3 s-input-wrapper', 'city', __( 'City', 'sogoc' ), 'text', '', $order_params['order_details']['city'] );
							?>
							<?php if ( array_key_exists( 'city', $help_array ) ): ?>
                                <span class="info-help">
                                            <?php echo $help_array['city']; ?>
                                        </span>
							<?php endif; ?>

                            <!-- Street -->
							<?php
							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'street',
								__( 'Street', 'sogoc' ),
								'text',
								'',
								isset( $order_params['street'] ) && ! is_array( $order_params['street'] ) ?
									$order_params['street'] : isset( $order_params['street'] ) && is_array( $order_params['street'] ) ?
									$order_params['street'][0] : ''
							);
							?>
							<?php if ( array_key_exists( 'street', $help_array ) ): ?>
                                <span class="info-help">
                                            <?php echo $help_array['street']; ?>
                                        </span>
							<?php endif; ?>

                            <!-- House number -->
							<?php
							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'house-number',
								__( 'House number', 'sogoc' ),
								'text',
								'',
								isset( $order_params['house-number'] ) && ! is_array( $order_params['house-number'] ) ?
									$order_params['house-number'] : isset( $order_params['house-number'] ) && is_array( $order_params['house-number'] ) ?
									$order_params['house-number'][0] : ''
							);
							?>
							<?php if ( array_key_exists( 'house-number', $help_array ) ): ?>
                                <span class="info-help">
                                            <?php echo $help_array['house-number']; ?>
                                        </span>
							<?php endif; ?>

                            <!-- Apartment number -->
							<?php
							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'apartment-number',
								__( 'Apartment number', 'sogoc' ),
								'text',
								'',
								isset( $order_params['apartment-number'] ) && ! is_array( $order_params['apartment-number'] ) ?
									$order_params['apartment-number'] : isset( $order_params['apartment-number'] ) && is_array( $order_params['apartment-number'] ) ?
									$order_params['apartment-number'][0] : ''
							);
							?>
							<?php if ( array_key_exists( 'apartment-number', $help_array ) ): ?>
                                <span class="info-help">
                                            <?php echo $help_array['apartment-number']; ?>
                                        </span>
							<?php endif; ?>
                            <!-- Terms & conditions 1 -->
                            <div class="col-lg-12">

                                <div class="form-group">

                                    <input type="checkbox" name="use-another-address"
                                           class="form-control use-another-address opacity-0"
                                           id="use-another-address"
										<?php echo isset( $order_params['use-another-address'] ) ? 'checked="checked"' : '' ?>

                                    />
									<?php if ( array_key_exists( 'use-another-address', $help_array ) ): ?>
                                        <span class="info-help">
                                            <?php echo $help_array['use-another-address']; ?>
                                        </span>
									<?php endif; ?>

                                    <label for="use-another-address"
                                           class="d-flex align-items-center checkbox-label text-5 color-6 flex-wrap">

                                        <span class="font-09em"><?php _e( 'Use different shipping address', 'sogoc' ); ?></span>

                                    </label>

                                </div>

                            </div>

                            <div class="col-lg-12">
                                <div class="container justify-content-between extra-field-box">
                                    <div class="row another-address <?php echo( isset( $order_params['use-another-address'] ) && ! empty( $order_params['use-another-address'] ) ? '' : ' d-none' ) ?>">
                                        <!-- City -->
										<?php
										//	sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'city-another', __( 'City', 'sogoc' ), 'text' );
										?>
                                        <div class="col-lg-5 mb-3 s-input-wrapper">

                                            <label for="city-another" class="text-5 color-6 d-block mb-1">עיר</label>

                                            <input id="city-another" name="city-another" class="w-100 city-another"
                                                   value="<?php echo( isset( $order_params['use-another-address'] ) && ! empty( $order_params['city-another'] ) ? $order_params['city-another'] : '' ) ?>"
                                                   type="text" disabled>

                                        </div>
										<?php if ( array_key_exists( 'city-another', $help_array ) ): ?>
                                            <span class="info-help">
                                                <?php echo $help_array['city-another']; ?>
                                            </span>
										<?php endif; ?>

                                        <!-- Street -->
										<?php
										$streetAnother = ( isset( $order_params['use-another-address'] ) && ! empty( $order_params['street-another'] ) ? $order_params['street-another'] : '' );
										sogo_do_input(
											'col-lg-5 mb-3 s-input-wrapper',
											'street-another',
											__( 'Street', 'sogoc' ),
											'text',
											'',
											$streetAnother
										);
										?>
										<?php if ( array_key_exists( 'street-another', $help_array ) ): ?>
                                            <span class="info-help">
                                                <?php echo $help_array['street-another']; ?>
                                            </span>
										<?php endif; ?>

                                        <!-- House number -->
										<?php
										$houseAnother = ( isset( $order_params['use-another-address'] ) && ! empty( $order_params['house-number-another'] ) ? $order_params['house-number-another'] : '' );
										sogo_do_input(
											'col-lg-5 mb-3 s-input-wrapper',
											'house-number-another',
											__( 'House number', 'sogoc' ),
											'text',
											'',
											$houseAnother
										);
										?>
										<?php if ( array_key_exists( 'house-number-another', $help_array ) ): ?>
                                            <span class="info-help">
                                                <?php echo $help_array['house-number-another']; ?>
                                            </span>
										<?php endif; ?>

                                        <!-- Apartment number -->
										<?php
										$apartmentAnother = ( isset( $order_params['use-another-address'] ) && ! empty( $order_params['apartment-number-another'] ) ? $order_params['apartment-number-another'] : '' );
										sogo_do_input(
											'col-lg-5 mb-3 s-input-wrapper',
											'apartment-number-another',
											__( 'Apartment number', 'sogoc' ),
											'text',
											'',
											$apartmentAnother
										);
										?>
										<?php if ( array_key_exists( 'apartment-number-another', $help_array ) ): ?>
                                            <span class="info-help">
                                                <?php echo $help_array['apartment-number-another']; ?>
                                            </span>
										<?php endif; ?>
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
                    <a class="collapsed d-flex align-items-center flex-wrap p-card" data-toggle=""
                       data-parent="#insurance-accordion"
                       href="#collapseFour"
                       aria-expanded="false" aria-controls="collapseThree">

                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

                        <span class="single-driver-js d-none"><?php _e( 'Driver details', 'sogoc' ); ?></span>
                        <span class="multi-driver-js"><?php _e( 'Drivers details', 'sogoc' ); ?></span>

                        <div class="d-flex flex-wrap selected-header-box"></div>

                    </a>
                </h5>
            </div>
            <div id="collapseFour" class="collapse content-top" role="tabpanel" aria-labelledby="headingFour">
                <div class="card-block mb-3">

                    <!-- CONTAINER-FLUID -->
                    <div class="container-fluid">

                        <!-- ROW -->
                        <div class="row justify-content-between driver-box">

                            <?php

//                            echo '<pre style="direction: ltr;">';
//                            var_dump($order_params);
//                            echo '</pre>';
                            ?>

                            <?php if (!isset($_GET['src'])) :?>
                            <!-- Driver first name -->
							<?php
							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'driver-first-name',
								__( 'First name', 'sogoc' ),
								'text',
								'',
								isset( $order_params['driver-first-name'] ) ? $order_params['driver-first-name'][0] : ''
							);
							?>
							<?php if ( array_key_exists( 'driver-first-name', $help_array ) ): ?>
                                <span class="info-help">
                                            <?php echo $help_array['driver-first-name']; ?>
                                        </span>
							<?php endif; ?>

                            <!-- Driver last name -->
							<?php
							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'driver-last-name',
								__( 'Last name', 'sogoc' ),
								'text',
								'',
								isset( $order_params['driver-last-name'] ) ? $order_params['driver-last-name'][0] : ''
							);
							?>
							<?php if ( array_key_exists( 'driver-last-name', $help_array ) ): ?>
                                <span class="info-help">
                                            <?php echo $help_array['driver-last-name']; ?>
                                        </span>
							<?php endif; ?>

                            <!-- Identical number (ID) -->
							<?php
							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'driver-identical-number',
								__( 'Identical number', 'sogoc' ),
								'text',
								'',
								isset( $order_params['driver-identical-number_0'] ) ? $order_params['driver-identical-number_0'] : ''
							);
							?>
							<?php if ( array_key_exists( 'driver-identical-number', $help_array ) ): ?>
                                <span class="info-help">
                                            <?php echo $help_array['driver-identical-number']; ?>
                                        </span>
							<?php endif; ?>

                            <!-- Choose birth date -->
                            <div class="col-lg-5 s-input-wrapper date-wrapper">

                                <label for="driver-birthday"
                                       class="text-5 color-6"><?php _e( 'Driver birthday', 'sogoc' ); ?></label>

                                <div class="form-group date-picker mb-0 hidden-lg-down">
									<?php
									$birthday = ( ( isset( $order_params['driver-birthday'] ) && isset( $order_params['driver-birthday'][0] ) ) ? $order_params['driver-birthday'][0] : '' );
									?>
                                    <input type="text" id="driver-birthday" readonly="readonly" name="driver-birthday[]"
                                           data-start="<?php echo $start_birthday; ?>"
                                           value="<?php echo $birthday; ?>"
                                           class="w-100 medium driver-birthday extra-driver-info datepicker"/>
                                </div>

                                <div class="form-group mb-0 hidden-lg-up">

                                    <div class="driver-birthday static-datepicker"></div>

                                </div>

								<?php if ( array_key_exists( 'driver-birthday', $help_array ) ): ?>
                                    <span class="info-help">
                                            <?php echo $help_array['driver-birthday']; ?>
                                        </span>
								<?php endif; ?>
                            </div>

                            <!-- Driver's gender -->
                            <div class="col-lg-5 mb-3 s-input-wrapper">

                                <div class="s-radio-wrapper">

                                    <label class="text-5 color-6 d-block mb-1">
										<?php _e( 'Driver\'s gender', 'sogoc' ); ?>
                                    </label>

                                    <div class="d-flex">

                                        <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                               name="driver-gender-0" id="driver-gender-1" value="1"
                                               data-val="male"

                                               checked="<?php ( isset( $order_params['driver-gender-2'] ) && $order_params['driver-gender-2'] === '1' ) ? 'checked' : '' ?>"

                                        >
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="driver-gender-1">
											<?php _e( 'Male', 'sogoc' ); ?>
                                        </label>

                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="driver-gender-0" id="driver-gender-2" value="2"
											<?php ( isset( $order_params['driver-gender-0'] ) && $order_params['driver-gender-0'] === '2' ) ? 'checked' : '' ?>
                                               data-val="female">
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="driver-gender-2">
											<?php _e( 'Female', 'sogoc' ); ?>
                                        </label>

                                    </div>

                                </div>

								<?php if ( array_key_exists( 'driver-gender', $help_array ) ): ?>
                                    <span class="info-help">
                                            <?php echo $help_array['driver-gender']; ?>
                                        </span>
								<?php endif; ?>
                            </div>

							<?php if ( isset( $order_params['drive-allowed'] ) && $order_params['drive-allowed'] === '2' ) : ?>

                                <div class="col-lg-5 mb-3 driver-license-box">
                                    <label for=""
                                           class="text-5 color-6 d-block mb-1"><?php echo _e( 'Year of issuing a license', 'sogoc' ); ?></label>

                                    <div class="s-select-wrapper">

										<?php
										$yearIssuingLicense = isset( $order_params['years-issuing-license'] ) && ! empty( $order_params['years-issuing-license'][0] ) ? $order_params['years-issuing-license'][0] : '';
										?>
                                        <select name="years-issuing-license[]"
                                                data-max-year="<?php echo $yearIssuingLicense ?>">

                                            <option value="">בחר</option>
                                        </select>

                                    </div>
                                </div>
                                <!-- If chosen that order owner is a draver we remove license year select from -->
							<?php endif; ?>
							<?php if ( array_key_exists( 'years-issuing-license', $help_array ) ): ?>
                                <span class="info-help">
                                            <?php echo $help_array['years-issuing-license']; ?>
                                        </span>
							<?php endif; ?>
                            <?php endif;?>
                            <div class="col-lg-12 extra-drivers">
								<?php if ( $order_params['drive-allowed'] === '2' && ( $order_params['order_details']['drive-allowed-number'] !== '1' || $order_params['order_details']['drive-allowed-number'] !== '4' ) ): ?>
                                    <!-- ROW -->
									<?php
									$id_driver_label = 3;
									foreach ( $order_params['driver-first-name'] as $key => $driver ) :


                                        if ( empty( $driver )  ) {
	                                        continue;
                                        }
										$gender_value_key = $key+1;
										$gender_value = ( isset( $order_params['driver-gender-'.$gender_value_key] ) && $order_params['driver-gender-'.$gender_value_key] === '1' ) ? 'checked' : '';
                                  //      $ddl_year = date("y"$order_params['driver-birthday'][$key]


                                    ?>

                                        <div class="row driver-box justify-content-between border-top border-width-x1 pt-3">
                                            <!-- Driver first name -->
											<?php
											sogo_do_input(
												'col-lg-5 mb-3 s-input-wrapper',
												'driver-first-name',
												__( 'First name', 'sogoc' ),
												'text',
												'',
												$driver
											);
											?>
											<?php if ( array_key_exists( 'driver-first-name', $help_array ) ): ?>
                                                <span class="info-help">
                                            <?php echo $help_array['driver-first-name']; ?>
                                        </span>
											<?php endif; ?>

                                            <!-- Driver last name -->
											<?php
											sogo_do_input(
												'col-lg-5 mb-3 s-input-wrapper',
												'driver-last-name',
												__( 'Last name', 'sogoc' ),
												'text',
												'',
												$order_params['driver-last-name'][ $key ]
											);
											?>
											<?php if ( array_key_exists( 'driver-last-name', $help_array ) ): ?>
                                                <span class="info-help">
                                            <?php echo $help_array['driver-last-name']; ?>
                                        </span>
											<?php endif; ?>

                                            <!-- Identical number (ID) -->
											<?php
											sogo_do_input(
												'col-lg-5 mb-3 s-input-wrapper',
												'driver-identical-number',
												__( 'Identical number', 'sogoc' ),
												'text',
												'',
												$order_params[ 'driver-identical-number_' . $key ]
											);
											?>
											<?php if ( array_key_exists( 'driver-identical-number', $help_array ) ): ?>
                                                <span class="info-help">
                                            <?php echo $help_array['driver-identical-number']; ?>
                                        </span>
											<?php endif; ?>

                                            <!-- Choose birth date -->
                                            <div class="col-lg-5 s-input-wrapper date-wrapper">

                                                <label for="driver-birthday"
                                                       class="text-5 color-6"><?php _e( 'Driver birthday', 'sogoc' ); ?></label>

                                                <div class="form-group date-picker mb-0 hidden-lg-down">

                                                    <input type="text" readonly="readonly" name="driver-birthday[]"
                                                           data-start="<?php echo $start_birthday; ?>"
                                                           value="<?php echo $order_params['driver-birthday'][ $key ]; ?>"
                                                           class="w-100 medium driver-birthday extra-driver-info datepicker"
                                                           onload=""
                                                    />
                                                </div>

                                                <div class="form-group mb-0 hidden-lg-up">

                                                    <div class="driver-birthday static-datepicker" ></div>

                                                </div>

												<?php if ( array_key_exists( 'driver-birthday', $help_array ) ): ?>
                                                    <span class="info-help">
                                            <?php echo $help_array['driver-birthday']; ?>
                                        </span>
												<?php endif; ?>
                                            </div>

                                            <!-- Driver's gender -->
                                            <div class="col-lg-5 mb-3 s-input-wrapper">

                                                <div class="s-radio-wrapper">

                                                    <label class="text-5 color-6 d-block mb-1">
														<?php _e( 'Driver\'s gender', 'sogoc' ); ?>
                                                    </label>

                                                    <div class="d-flex">

                                                        <input type="radio"
                                                               class="form-radio-input opacity-0 p-absolute"
                                                               name="driver-gender-<?php echo $gender_value_key ?>"
                                                               value="1"
                                                               data-val="male"
                                                               id="driver-gender-<?php echo $id_driver_label ?>"
                                                               checked="<?php echo $gender_value ?>"

                                                        >
                                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                               for="driver-gender-<?php echo $id_driver_label ++ ?>">
															<?php _e( 'Male', 'sogoc' ); ?>
                                                        </label>

                                                        <input type="radio" class="form-radio-input opacity-0"
                                                               name="driver-gender-<?php echo $gender_value_key ?>"
                                                               value="2"
                                                               id="driver-gender-<?php echo $id_driver_label ?>"
                                                               checked="<?php echo $gender_value ?>"
                                                               data-val="female">
                                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                               for="driver-gender-<?php echo $id_driver_label ++ ?>">
															<?php _e( 'Female', 'sogoc' ); ?>
                                                        </label>

                                                    </div>

                                                </div>

												<?php if ( array_key_exists( 'driver-gender', $help_array ) ): ?>
                                                    <span class="info-help">
                                            <?php echo $help_array['driver-gender']; ?>
                                        </span>
												<?php endif; ?>
                                            </div>

                                            <!-- Years of issuing license -->
                                            <div class="col-lg-5 mb-3 driver-license-box">
                                                <label for=""
                                                       class="text-5 color-6 d-block mb-1"><?php echo _e( 'Year of issuing a license', 'sogoc' ); ?></label>

                                                <div class="s-select-wrapper">

                                                    <select name="years-issuing-license[]"
                                                            data-max-year="<?php echo $max_year_by_seniority; ?>"  >
                                                        <option value="<?php echo $order_params['years-issuing-license'][$key] ?>"><?php echo $order_params['years-issuing-license'][$key] ?></option>

                                                    </select>

                                                </div>
                                            </div>
                                        </div>
									<?php endforeach; ?>

								<?php endif; ?>

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
            <div class="card-header p-0" role="tab" id="headingFive">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center p-card" data-toggle=""
                       data-parent="#insurance-accordion"
                       href="#collapseFive"
                       aria-expanded="false" aria-controls="collapseFive">

                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

						<?php _e( 'Extra coverage', 'sogoc' ); ?>

                        <div class="d-flex flex-wrap selected-header-box"></div>

                    </a>
                </h5>
            </div>


            <div id="collapseFive" class="collapse content-top" role="tabpanel" aria-labelledby="headingFive">
                <div class="card-block mb-3">
                    <div class="container-fluid">
                        <div class="row justify-content-between">
                            <div class="col-lg-12 payment-default">
                                <div class="row justify-content-between">

                                    <!-- Up Sales block -->
									<?php
									//$ins_type
									$insurance_upsalesArr = [];
									$upsales              = get_field( 'insurance_upsales', 'options' );
									$index                = 0;
									?>

<!--                                    <script>-->
<!--                                        function fo(elem) {-->
<!--                                            console.log(elem)-->
<!--                                        }-->
<!--                                    </script>-->


									<?php if ( have_rows( 'insurance_upsales', 'options' ) ) : ?>

                                        <div class="col-lg-6 upsales-default">
											<?php while ( have_rows( 'insurance_upsales', 'options' ) ): the_row(); ?>
                                            <?php
												$checked = ( get_sub_field( 'upsales_product_name' ) == $order_params['upsales-product-name'][ $index ] ) ? ' checked ' : '';
                                                ?>


                                                <div class="upsale-info">
                                                    <input readonly="readonly" type="hidden"
                                                           name="upsales-product-name[]"
                                                           value="<?php the_sub_field( 'upsales_product_name' ); ?>">
                                                    <input readonly="readonly" type="hidden"
                                                           name="upsales-product-description[]"
                                                           value="<?php the_sub_field( 'upsales_product_description' ); ?>"
                                                    >
                                                </div>
												<?php if ( get_sub_field( 'insurance_type' ) == $ins_type ) : ?>

                                                    <div class="upsales-box form-group mb-2"
                                                         id="upsales_box_<?php echo $index; ?>"
                                                         data-id="<?php echo $index; ?>">

                                                        <input type="checkbox"
															<?php echo $checked;?>
                                                               name="upsale_<?php the_sub_field( 'upsale_sku' ); ?>"
                                                               data-price="<?php the_sub_field( 'upsales_price' ); ?>"
                                                               data-id="<?php the_sub_field( 'upsale_sku' ); ?>"
                                                               id="upsale_<?php the_sub_field( 'upsale_sku' ); ?>"
                                                               class="upsale-checkbox form-control opacity-0"

                                                        >

                                                        <label for="upsale_<?php the_sub_field( 'upsale_sku' ); ?>"
                                                               class="d-flex align-items-center checkbox-label text-5 color-6 flex-wrap">
                                                            <span class="font-09em"><?php the_sub_field( 'upsales_product_name' ); ?>
                                                                - <?php the_sub_field( 'upsales_price' ); ?>
                                                                &#8362;</span><br>
                                                            <span class="text-6"><?php the_sub_field( 'upsales_product_description' ); ?></span><br>

															<?php if ( get_sub_field( 'upsale_product_file' ) && ! empty( get_sub_field( 'upsale_product_file' ) ) ) : ?>
                                                                <a href="<?php the_sub_field( 'upsale_product_file' ); ?>"
                                                                   target="_blank">הורד קובץ</a>
															<?php endif; ?>
                                                        </label>


                                                    </div>

												<?php endif; ?>
												<?php $index ++; ?>
											<?php endwhile; ?>
                                        </div>
									<?php endif; ?>
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


        <!-- TAB 6 -->
        <div class="card">
            <div class="card-header p-0" role="tab" id="headingSix">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center p-card" data-toggle=""
                       data-parent="#insurance-accordion"
                       href="#collapseSix"
                       aria-expanded="false" aria-controls="collapseSix">

                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

						<?php _e( 'Payment details', 'sogoc' ); ?>

                        <div class="d-flex flex-wrap selected-header-box"></div>

                    </a>
                </h5>
            </div>

            <div id="collapseSix" class="collapse content-top" role="tabpanel" aria-labelledby="headingSix">
                <div class="card-block mb-3">

                    <!-- CONTAINER-FLUID -->
                    <div class="container-fluid">
                        <!-- ROW -->
                        <div class="row justify-content-between">

                            <!-- Terms & conditions 1 -->
                            <div class="col-lg-12 payment-default">

                                <div class="form-group">

                                    <input type="checkbox" name="use-phone-payment"
                                           class="form-control use-phone-payment opacity-0"
                                           id="use-phone-payment"/>
									<?php if ( array_key_exists( 'use-phone-payment', $help_array ) ): ?>
                                        <span class="info-help">
                                            <?php echo $help_array['use-phone-payment']; ?>
                                        </span>
									<?php endif; ?>

                                    <label for="use-phone-payment"
                                           class="d-flex align-items-center checkbox-label text-5 color-6 flex-wrap">

                                        <span class="font-09em"><?php _e( 'Use phone payment', 'sogoc' ); ?></span>

                                    </label>

                                </div>

                                <div class="payment-box">
                                    <div class="row justify-content-between">
                                        <!-- Cardholder name -->
										<?php
										sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'cardholder-name', __( 'Cardholder name', 'sogoc' ), 'text' );
										?>
										<?php if ( array_key_exists( 'cardholder-name', $help_array ) ): ?>
                                            <span class="info-help">
                                            <?php echo $help_array['cardholder-name']; ?>
                                        </span>
										<?php endif; ?>

                                        <!-- Identical number (ID) of cardholder -->
										<?php
										sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'cardholder-id', __( 'Cardholder ID', 'sogoc' ), 'text' );
										?>
										<?php if ( array_key_exists( 'cardholder-id', $help_array ) ): ?>
                                            <span class="info-help">
                                            <?php echo $help_array['cardholder-id']; ?>
                                        </span>
										<?php endif; ?>

                                        <!-- Number of credit card -->
										<?php
										sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'card-number', __( 'Number of credit card', 'sogoc' ), 'text' );
										?>
										<?php if ( array_key_exists( 'card-number', $help_array ) ): ?>
                                            <span class="info-help">
                                            <?php echo $help_array['card-number']; ?>
                                        </span>
										<?php endif; ?>


										<?php if ( array_key_exists( 'card-month', $help_array ) ): ?>
                                            <span class="info-help">
                                            <?php echo $help_array['card-month']; ?>
                                        </span>
										<?php endif; ?>

                                        <div class="col-lg-5 mb-3">
                                            <div class="row">
                                                <div class="col-6">

                                                    <label for="card-year"
                                                           class="text-5 color-6 d-block mb-1"><?php echo _e( 'Card validity year', 'sogoc' ); ?></label>

                                                    <div class="s-select-wrapper">

                                                        <select name="card-year" id="card-year">

                                                            <option value="">בחר</option>
															<?php for ( $i = $curr_year; $i <= ( $curr_year + 8 ); $i ++ ): ?>
                                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
															<?php endfor; ?>
                                                        </select>

                                                    </div>
                                                </div>

                                                <!-- Validity of credit card  -->

                                                <div class="col-6">
                                                    <label for="card-month"
                                                           class="text-5 color-6 d-block mb-1"><?php echo _e( 'Card validity month', 'sogoc' ); ?></label>

                                                    <div class="s-select-wrapper">

                                                        <select name="card-month" id="card-month">

                                                            <option value="">בחר</option>
															<?php for ( $i = 1; $i <= 12; $i ++ ): ?>
                                                                <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
															<?php endfor; ?>
                                                        </select>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>


										<?php
										//		                            sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'card-year', __( 'Card validity year', 'sogoc' ), 'text' );
										?>
										<?php if ( array_key_exists( 'card-year', $help_array ) ): ?>
                                            <span class="info-help">
                                            <?php echo $help_array['card-year']; ?>
                                        </span>
										<?php endif; ?>
                                        <input type="hidden"
                                               name="num-payments-no-percents"
                                               id="num-payments-no-percent"
                                               value="<?php echo (int) $companies_settings[ $order_params['order_details']['company_id'] ]['num_payments_no_percents']; ?>">
                                        <!-- Number of payments for mandatory  -->
                                        <div class="col-lg-5 mb-3">
											<?php
											//			                            echo '<pre style="direction: ltr;">';
											//			                            var_dump($order_params);
											//			                            echo '</pre>';
											$mandatory_payments = (int) $companies_settings[ $order_params['order_details']['company_id'] ]['mandatory_num_payments'];
											$mandat_array       = array();

											for ( $i = 1; $i <= $mandatory_payments; $i ++ ) {
												$mandat_array[ $i ] = $i;
											}

											sogo_do_select( __( 'Number of payments for mandatory', 'sogoc' ), 'mandat-num-payments', $mandat_array );
											?>
											<?php if ( array_key_exists( 'mandat-num-payments', $help_array ) ): ?>
                                                <span class="info-help">
                                            <?php echo $help_array['mandat-num-payments']; ?>
                                        </span>
											<?php endif; ?>
                                        </div>
										<?php if ( ! empty( $order_params['order_details']['price_havila'] ) && $order_params['order_details']['price_havila'] > 0 ): ?>
                                            <!-- Number of payments for comprehensive/third party  -->
                                            <div class="col-lg-5 mb-3">
												<?php

												$havila_payment_payments = (int) $companies_settings[ $order_params['order_details']['company_id'] ]['havila_num_payments'];
												$havila_payment_array    = array();

												for ( $i = 1; $i <= $havila_payment_payments; $i ++ ) {
													$havila_payment_array[ $i ] = $i;
												}

												sogo_do_select( __( 'Number of payments for comprehensive', 'sogoc' ), 'havila-num-payments', $havila_payment_array );
												?>
												<?php if ( array_key_exists( 'other-num-payments', $help_array ) ): ?>
                                                    <span class="info-help">
                                                            <?php echo $help_array['other-num-payments']; ?>
                                                        </span>
												<?php endif; ?>
                                            </div>
										<?php endif; ?>
										<?php if ( ! empty( $order_params['order_details']['insurance-type'] ) && $order_params['order_details']['second_price'] ): ?>
                                            <!-- Number of payments for comprehensive/third party  -->
                                            <div class="col-lg-5 mb-3">
												<?php
												$other_payment_payments = (int) $companies_settings[ $order_params['order_details']['company_id'] ]['other_num_payments'];
												$other_payment_array    = array();

												for ( $i = 1; $i <= $other_payment_payments; $i ++ ) {
													$other_payment_array[ $i ] = $i;
												}

												sogo_do_select( __( 'Number of payments for comprehensive', 'sogoc' ), 'other-num-payments', $other_payment_array );
												?>
												<?php if ( array_key_exists( 'other-num-payments', $help_array ) ): ?>
                                                    <span class="info-help">
                                            <?php echo $help_array['other-num-payments']; ?>
                                        </span>
												<?php endif; ?>

                                            </div>
										<?php endif; ?>
                                        <div class="col-lg-5 mb-3 d-none" id="upsales_number_payments">
											<?php
											$upsales_payment_payments = (int) $companies_settings[ $order_params['order_details']['company_id'] ]['upsales_number_payments'];
											$upsales_payment_array    = array();

											for ( $i = 1; $i <= $upsales_payment_payments; $i ++ ) {
												$upsales_payment_array[ $i ] = $i;
											}

											sogo_do_select( __( 'Number of payments for upsales', 'sogoc' ), 'upsales-number-payments', $upsales_payment_array );
											?>
											<?php if ( array_key_exists( 'upsales-num-payments', $help_array ) ): ?>
                                                <span class="info-help">
                                            <?php echo $help_array['upsales-num-payments']; ?>
                                        </span>
											<?php endif; ?>

                                            <!--                                            <label for="upsales_number_payments"-->
                                            <!--                                                   class="text-5 color-6 d-inline-block mb-1">תשלומים אפסייל - <span class="upsales-price-info"></span><span> &#8362;</span>-->
                                            <!--                                            </label>-->
                                            <!--                                            <div class="s-select-wrapper">-->
                                            <!--                                                <select name="upsales-number-payments" id="upsale_number_payments"  class="upsales-number-payments">-->
                                            <!--                                                    <option value="">בחר</option>-->
                                            <!--                                                    <option value="1">1</option>-->
                                            <!--                                                    <option value="2">2</option>-->
                                            <!--                                                </select>-->
                                            <!--                                            </div>-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="ins-company"
                           value="<?php echo stripslashes( $order_params['order_details']['ins_company'] ); ?>">
                    <input type="hidden" name="mandat-price"
                           value="<?php echo $order_params['order_details']['mandat_price']; ?>">
					<?php
					//                echo '<pre style="direction: ltr;">';
					//                var_dump($order_params);
					//                echo '</pre>';
					if ( isset( $order_params['order_details']['price_havila'] ) && $order_params['order_details']['price_havila'] > 0 ) {
						$price = intval( $order_params['order_details']['second_price'] ) - intval( $order_params['order_details']['price_havila'] );
					} else {
						$price = $order_params['order_details']['second_price'];
					}
					?>
                    <input type="hidden" name="second-price" value="<?php echo $price; ?>">
                    <input type="hidden" name="old-price" value="<?php echo $price; ?>">
                    <input type="hidden" name="package-price"
                           value="<?php echo $order_params['order_details']['price_havila']; ?>">
                    <input type="hidden" name="upsales-price" id="upsales_price" value="">

                    <!-- CONTAINER-FLUID -->
                    <div class="container-fluid mb-3">


                        <!-- ROW -->
                        <div class="row justify-content-between">
                            <!-- Drive on saturday -->
                            <div class="col-lg-5 mb-3">

                                <div class="s-radio-wrapper">

                                    <!-- tooltip -->
									<?php sogo_include_tooltip( 'policy-send', $help_array, __( 'Policy send', 'sogoc' ), $help_array['policy-send'] ); ?>

                                    <label class="text-5 color-6 d-inline-block mb-1">
										<?php _e( 'Policy send', 'sogoc' ); ?>
                                    </label>

                                    <div class="d-flex">

										<?php
										//										if ( ! isset( $_GET['ins_order'] ) ) {
										//											$check1 = sogo_if_checked_from_cookie( 'criminal-record', '1' );
										//											$check2 = sogo_if_checked_from_cookie( 'criminal-record', '2' );
										//										} else {
										$check1 = $order_params['order_details']['policy-send'] == '1' ? 'checked' : '';
										$check2 = $order_params['order_details']['policy-send'] == '2' ? 'checked' : '';
										//	}
										?>

                                        <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                               name="policy-send" id="policy-send-1" value="1"
                                               data-val="yes" <?php echo $check1; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="policy-send-1">
											<?php _e( 'Yes, send me original', 'sogoc' ); ?>
                                        </label>

                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="policy-send" id="policy-send-2" value="2"
                                               data-val="no" <?php echo $check2; ?>>
                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="policy-send-2">
											<?php _e( 'No, a copy will be good', 'sogoc' ); ?>
                                        </label>

                                    </div>

                                </div>

                            </div>
                        </div>


                        <!-- ROW -->
                        <div class="row justify-content-between">

                            <!-- Terms & conditions 1 -->
                            <div class="col-lg-12">

                                <div class="form-group">

                                    <input type="checkbox"
                                           name="tac-1" <?php echo isset( $_GET['ins_order'] ) || isset( $_COOKIE['ins_order'] ) ? 'checked' : ''; ?>
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


                        <!-- ROW -->
                        <div class="row">

                            <div class="col-lg-12">

                                <div class="text-left">

                                    <button type="submit"
                                            data-link="<?php echo get_field( '_sogo_link_to_thank', 'option' ); ?>"
                                            class="s-button s-button-2 bg-5 border-color-5 insurance-submit-payment">
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


<div class="d-none driver-info">

    <div class="row driver-box justify-content-between border-top border-width-x1 pt-3">

        <!-- Driver first name -->
		<?php
		sogo_do_input_1( 'col-lg-5 mb-3 s-input-wrapper', 'driver-first-name', __( 'First name', 'sogoc' ), 'text' );
		?>

        <!-- Driver last name -->
		<?php
		sogo_do_input_1( 'col-lg-5 mb-3 s-input-wrapper', 'driver-last-name', __( 'Last name', 'sogoc' ), 'text' );
		?>

        <!-- Identical number (ID) -->
		<?php
		sogo_do_input_1( 'col-lg-5 mb-3 s-input-wrapper', 'driver-identical-number', __( 'Identical number', 'sogoc' ), 'text' );
		?>

        <!-- Choose birth date -->
        <div class="col-lg-5 s-input-wrapper date-wrapper">

            <div class="form-group date-picker mb-0 hidden-lg-down">
                <label
                        class="text-5 color-6"><?php _e( 'Driver birthday', 'sogoc' ); ?></label>
                <input type="text" readonly="readonly" name="driver-birthday[]"
                       class="w-100 medium datepicker driver-birthday extra-driver-info"/>
            </div>

            <div class="form-group mb-0 hidden-lg-up">

                <div class="datepicker static-datepicker"></div>

            </div>

        </div>

        <!-- Driver's gender -->
        <div class="col-lg-5 mb-3 s-input-wrapper">

            <div class="s-radio-wrapper">

                <label class="text-5 color-6 d-block mb-1">
					<?php _e( 'Driver\'s gender', 'sogoc' ); ?>
                </label>

                <div class="d-flex gender-input">

                    <input type="radio" class="form-radio-input opacity-0 p-absolute"
                           name="driver-gender" value="1"
                           data-val="male">
                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                           for="">
						<?php _e( 'Male', 'sogoc' ); ?>
                    </label>

                    <input type="radio" class="form-radio-input opacity-0"
                           name="driver-gender" value="2"
                           data-val="female">
                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                           for="">
						<?php _e( 'Female', 'sogoc' ); ?>
                    </label>

                </div>

            </div>

        </div>

        <!-- Years of issuing license -->
        <div class="col-lg-5 mb-3 driver-license-box">
            <label for=""
                   class="text-5 color-6 d-block mb-1"><?php echo _e( 'Year of issuing a license', 'sogoc' ); ?></label>

            <div class="s-select-wrapper">

                <select name="years-issuing-license[]" data-max-year="<?php echo $max_year_by_seniority; ?>">

                    <option value="">בחר</option>
                </select>

            </div>
        </div>
		<?php
		//TODO: prepare data of years
		//        sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'years-issuing-license', __( 'Year of issuing a license', 'sogoc' ), 'text', '', true );
		?>

    </div>

</div>

<!--<div class="d-none license-box-wrapper">-->
<!--    <div class="col-lg-5 mb-3 license-box">-->
<!--        <label for="license-year"-->
<!--               class="text-5 color-6 d-block mb-1">--><?php //echo _e( 'Year of issuing a license', 'sogoc' ); ?><!--</label>-->
<!---->
<!--        <div class="s-select-wrapper">-->
<!---->
<!--            <select name="license-year" id="license-year" data-max-year="--><?php //echo $max_year_by_seniority;?><!--">-->
<!---->
<!--                <option value="">בחר</option>-->
<!--            </select>-->
<!---->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!--<div class="d-none example-payment-box">-->
<!--    <div class="payment-box">-->
<!--        <div class="row justify-content-between">-->
<!--        <!-- Cardholder name -->
<!--		--><?php
//		sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'cardholder-name', __( 'Cardholder name', 'sogoc' ), 'text' );
//		?>
<!--		--><?php //if(array_key_exists('cardholder-name', $help_array)):?>
<!--            <span class="info-help">-->
<!--                                            --><?php //echo $help_array['cardholder-name'];?>
<!--                                        </span>-->
<!--		--><?php //endif;?>
<!---->
<!--        <!-- Identical number (ID) of cardholder -->
<!--		--><?php
//		sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'cardholder-id', __( 'Cardholder ID', 'sogoc' ), 'text' );
//		?>
<!--		--><?php //if(array_key_exists('cardholder-id', $help_array)):?>
<!--            <span class="info-help">-->
<!--                                            --><?php //echo $help_array['cardholder-id'];?>
<!--                                        </span>-->
<!--		--><?php //endif;?>
<!---->
<!--        <!-- Number of credit card -->
<!--		--><?php
//		sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'card-number', __( 'Number of credit card', 'sogoc' ), 'text' );
//		?>
<!--		--><?php //if(array_key_exists('card-number', $help_array)):?>
<!--            <span class="info-help">-->
<!--                                            --><?php //echo $help_array['card-number'];?>
<!--                                        </span>-->
<!--		--><?php //endif;?>
<!---->
<!--        <!-- Validity of credit card  -->
<!---->
<!--        <div class="col-lg-5 mb-3">-->
<!--            <label for="card-month"-->
<!--                   class="text-5 color-6 d-block mb-1">--><?php //echo _e( 'Card validity month', 'sogoc' ); ?><!--</label>-->
<!---->
<!--            <div class="s-select-wrapper">-->
<!---->
<!--                <select name="card-month" id="card-month">-->
<!---->
<!--                    <option value="">בחר</option>-->
<!--                    --><?php //for ($i = 1; $i <= 12; $i++):?>
<!--                        <option value="--><?php // echo $i;?><!--">--><?php //echo $i;?><!--</option>-->
<!--                    --><?php //endfor; ?>
<!--                </select>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--		--><?php //if(array_key_exists('card-month', $help_array)):?>
<!--            <span class="info-help">-->
<!--                                            --><?php //echo $help_array['card-month'];?>
<!--                                        </span>-->
<!--		--><?php //endif;?>
<!---->
<!--        <div class="col-lg-5 mb-3">-->
<!--            <label for="card-year"-->
<!--                   class="text-5 color-6 d-block mb-1">--><?php //echo _e( 'Card validity year', 'sogoc' ); ?><!--</label>-->
<!---->
<!--            <div class="s-select-wrapper">-->
<!---->
<!--                <select name="card-year" id="card-year">-->
<!---->
<!--                    <option value="">בחר</option>-->
<!--                    --><?php //for ($i = $curr_year; $i <= ($curr_year + 8); $i++):?>
<!--                        <option value="--><?php // echo $i;?><!--">--><?php //echo $i;?><!--</option>-->
<!--                    --><?php //endfor; ?>
<!--                </select>-->
<!---->
<!--            </div>-->
<!--        </div>-->
<!--		--><?php //if(array_key_exists('card-year', $help_array)):?>
<!--            <span class="info-help">-->
<!--                                            --><?php //echo $help_array['card-year'];?>
<!--                                        </span>-->
<!--		--><?php //endif;?>
<!---->
<!--        <!-- Number of payments for mandatory  -->
<!--        <div class="col-lg-5 mb-3">-->
<!--			--><?php
//			$mandatory_payments = (int)$companies_settings[$order_params['order_details']['company_id']]['mandatory_num_payments'];
//			$mandat_array = array();
//
//			for ($i = 1; $i <= $mandatory_payments; $i++){
//				$mandat_array[$i] = $i;
//			}
//
//			sogo_do_select( __( 'Number of payments for mandatory', 'sogoc' ), 'mandat-num-payments', $mandat_array);
//			?>
<!--			--><?php //if(array_key_exists('mandat-num-payments', $help_array)):?>
<!--                <span class="info-help">-->
<!--                                            --><?php //echo $help_array['mandat-num-payments'];?>
<!--                                        </span>-->
<!--			--><?php //endif;?>
<!--        </div>-->
<!---->
<!--		--><?php //if(!empty($order_params['order_details']['insurance-type'])):?>
<!--            <!-- Number of payments for comprehensive/third party  -->
<!--            <div class="col-lg-5 mb-3">-->
<!--				--><?php
//				$other_payment_payments = (int)$companies_settings[$order_params['order_details']['company_id']]['other_num_payments'];
//				$other_payment_array = array();
//
//				for ($i = 1; $i <= $other_payment_payments; $i++){
//					$other_payment_array[$i] = $i;
//				}
//
//				sogo_do_select( __( 'Number of payments for comprehensive', 'sogoc' ), 'other-num-payments', $other_payment_array );
//				?>
<!--				--><?php //if(array_key_exists('other-num-payments', $help_array)):?>
<!--                    <span class="info-help">-->
<!--                                            --><?php //echo $help_array['other-num-payments'];?>
<!--                                        </span>-->
<!--				--><?php //endif;?>
<!--            </div>-->
<!--		--><?php //endif; ?>
<!--        </div>-->
<!--    </div>-->
<!--</div>-->