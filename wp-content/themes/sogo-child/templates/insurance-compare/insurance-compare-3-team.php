<?php
$help_array = array();

$info_rows = get_field( '_sogo_info_help', 'option' );

foreach ( $info_rows as $row ) {
	$help_array[ $row['name'] ] = $row['text'];
}


?>

<form action="<?php echo add_query_arg( 'insurance-type', $_GET['insurance-type'], get_permalink( get_field( '_sogo_insurance_compare_2_link', 'option' ) ) ); ?>"
      method="post"
      id="form-2">
    <input name="ins_link" type="hidden" value="<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
    <input name="ins-type" type="hidden" value="<?php echo $insType ?>">
    <input name="source-srm" type="hidden" value="<?php echo $src; ?>"/>
    <input name="ins-order" type="hidden" value="<?php echo $ins_order; ?>"/>
    <div id="insurance-accordion" role="tablist" aria-multiselectable="true">

        <!-- TAB 1 -->
        <div class="card card-current">
            <div class="card-header" role="tab" id="headingOne">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center flex-wrap" data-toggle="collapse"
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

                        <!-- ROW -->
                        <div class="row justify-content-between">

                            <div class="col-lg-5 mb-3 s-input-wrapper">

								<?php if ( array_key_exists( 'license-number', $help_array ) ): ?>
                                    <!--                                    <span class="info-help">-->
                                    <!--                                            --><?php //echo $help_array['license-number']; ?>
                                    <!--                                        </span>-->
									<?php sogo_include_tooltip( 'license-number', $help_array, __( 'License number', 'sogoc' ), $help_array['license-number'] ); ?>

								<?php endif; ?>

                                <label for="license-number"
                                       class="text-5 color-6 d-inline-block mb-1"><?php echo __( 'License number', 'sogoc' ); ?></label>

                                <input type="text"
                                       maxlength="8"
                                       data-year="<?php echo $order_params ['order_details']['vehicle-year'] ?>"
                                       id="license-number"
                                       name="license-number" class="w-100"
                                       value="<?php echo( isset( $order_params['license-number'] )
									       ? $order_params['license-number'] : '' ) ?>"/>


                            </div>

                            <!-- Vehicle manufacturer -->
                            <div class="col-lg-5 mb-3">

                                <div class="s-radio-wrapper">
									<?php if ( array_key_exists( 'ownership-date', $help_array ) ): ?>
										<?php sogo_include_tooltip( 'ownership-date', $help_array, __( 'Ownership date', 'sogoc' ), $help_array['ownership-date'] ); ?>
									<?php endif; ?>
                                    <label class="text-5 color-6 d-inline-block mb-1">
										<?php _e( 'Ownership date', 'sogoc' ); ?>
                                    </label>

                                    <div class="d-flex">


                                        <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                               name="ownership-date" id="ownership-date-1" value="1"
											<?php echo( isset( $order_params['ownership-date'] ) && $order_params['ownership-date'] === '1' ? 'checked' : '' ) ?>
                                               data-val="under-year">

                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="ownership-date-1">
											<?php _e( 'Under a year', 'sogoc' ); ?>
                                        </label>

                                        <input type="radio" class="form-radio-input opacity-0"
                                               name="ownership-date" id="ownership-date-2" value="2"
											<?php echo( isset( $order_params['ownership-date'] ) && $order_params['ownership-date'] === '2' ? 'checked' : '' ) ?>
                                               data-val="above-year">

                                        <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                               for="ownership-date-2">
											<?php _e( 'Above a year', 'sogoc' ); ?>
                                        </label>

                                    </div>

                                </div>


                            </div>
							<?php

							$class = isset( $order_params['ownership-date'] ) && $order_params['ownership-date'] === '1' ? '' : ' d-none ';

							?>

                            <!-- Choose car ownership date -->
                            <div class="col-lg-5 s-input-wrapper <?php echo $class; ?> under">

                                <label class="text-5 color-6"><?php _e( 'Choose car ownership car date', 'sogoc' ); ?></label>
                                <div class="form-group date-picker mb-0  ">
                                    <input type="text"
                                           value="<? echo( isset( $order_params['ownership-date'] ) && $order_params['ownership-date'] === '1' ? $order_params['ownership-under-year'] : '' ) ?>"
                                           readonly="readonly" name="ownership-under-year"
                                           class="w-100 medium under-year"/>
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
            <div class="card-header" role="tab" id="headingTwo">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center flex-wrap" data-toggle=""
                       data-parent="#insurance-accordion"
                       href="#collapseTwo"
                       aria-expanded="false" aria-controls="collapseTwo">

                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

						<?php echo __( 'Details of the policyholder', 'sogoc' ) . '  '; ?>

                        <div class="d-flex flex-wrap selected-header-box"></div>

                    </a>
                </h5>
            </div>
            <div id="collapseTwo" class="collapse content-top " role="tabpanel" aria-labelledby="headingTwo">
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
									isset( $order_params['first-name'] ) ? $order_params['first-name'] : '',
									$help_array
								);
								?>


                                <!-- Last name -->
								<?php
								sogo_do_input(
									'mb-3 s-input-wrapper',
									'last-name',
									__( 'Last name', 'sogoc' ),
									'text',
									'',
									isset( $order_params['last-name'] ) ? $order_params['last-name'] : '',
									$help_array
								);
								?>


                                <!-- Identical number (ID) -->
								<?php
								sogo_do_input(
									'mb-3 s-input-wrapper',
									'identical-number',
									__( 'Identical number', 'sogoc' ),
									'text',
									'',
									isset( $order_params['identical-number'] ) ? $order_params['identical-number'] : '',
									$help_array
								);
								?>

								<?php
								$current_time          = new DateTime( 'now', $time_zone );
								$curr_year             = (int) $current_time->format( 'Y' );
								$seniority             = (int) $order_params['order_details']['lowest-seniority'];
								$max_year_by_seniority = $curr_year - $seniority;
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
                                    <div class="form-group date-picker mb-0  ">
                                        <input type="text" readonly="readonly" name="birthday-date"
                                               data-start="<?php echo $start_birthday; ?>"
                                               class="w-100 medium birthday-date datepicker"
                                               value="<?php echo isset( $order_params['birthday-date'] ) ? $order_params['birthday-date'] : '' ?>"
                                        />
                                    </div>



                                </div>

                            </div>

                            <div class="col-md-2"></div>


                            <div class="col-md-5">
                                <!-- Choose birth date -->


                                <!-- Youngest insurance gender -->
                                <div class="mb-3 s-input-wrapper">

                                    <div class="s-radio-wrapper">
										<?php if ( array_key_exists( 'gender', $help_array ) ): ?>
											<?php sogo_include_tooltip( 'gender', $help_array, __( 'Youngest driver\'s gender', 'sogoc' ), $help_array['gender'] ); ?>
										<?php endif; ?>
                                        <label class="text-5 color-6 d-inline-block mb-1">
											<?php //_e( 'Youngest driver\'s gender', 'sogoc' ); ?>

											<?php _e( 'The gender of the policyholder', 'sogoc' ); ?>
                                        </label>

                                        <div class="d-flex">

                                            <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                                   name="gender" id="gender-1" value="1"
												<?php echo( isset( $order_params['gender'] ) && $order_params['gender'] === '1' ? 'checked' : '' ) ?>
                                                   data-val="male">
                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                   for="gender-1">
												<?php _e( 'Male', 'sogoc' ); ?>
                                            </label>

                                            <input type="radio" class="form-radio-input opacity-0"
                                                   name="gender" id="gender-2" value="2"
												<?php echo( isset( $order_params['gender'] ) && $order_params['gender'] === '2' ? 'checked' : '' ) ?>
                                                   data-val="female">
                                            <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                   for="gender-2">
												<?php _e( 'Female', 'sogoc' ); ?>
                                            </label>

                                        </div>

                                    </div>

                                </div>

                                <!-- Drive allowed number -->
                                <div class="mb-3 s-input-wrapper">

                                    <div class="s-radio-wrapper">

										<?php if ( array_key_exists( 'drive-allowed', $help_array ) ): ?>
											<?php sogo_include_tooltip( 'drive-allowed', $help_array, __( 'Is the policyholder one of the drivers in the vehicle?', 'sogoc' ), $help_array['drive-allowed'] ); ?>
										<?php endif; ?>

                                        <label class="text-5 color-6 d-inline-block mb-1">
											<?php _e( 'Is the policyholder one of the drivers in the vehicle?', 'sogoc' ); ?>
                                        </label>

                                        <div class="d-flex"
                                             data-allowed="<?php echo $order_params['order_details']['drive-allowed-number']; ?>">

                                            <input type="radio"
                                                   class="form-radio-input opacity-0 p-absolute drive-allowed"
                                                   name="drive-allowed" id="drive-allowed-1" value="1"
												<?php
												echo( isset( $order_params['drive-allowed'] ) && $order_params['drive-allowed'] === '1' ? 'checked' : '' )
												?>
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

                                </div>

                                <div class="mb-3 license-box <?php echo ( ! isset( $order_params['drive-allowed'] ) || ( isset( $order_params['drive-allowed'] ) && $order_params['drive-allowed'] === '2' ) ) ? ' d-none' : '' ?>">
									<?php if ( array_key_exists( 'license-year', $help_array ) ): ?>
										<?php sogo_include_tooltip( 'license-year', $help_array, __( 'Year of issuing a license', 'sogoc' ), $help_array['license-year'] ); ?>
									<?php endif; ?>

                                    <label for="license-year"
                                           class="text-5 color-6 d-inline-block mb-1"><?php echo _e( 'Year of issuing a license', 'sogoc' ); ?></label>
									<?php
									$selectedYear = isset( $order_params['license-year'] ) && ! empty( $order_params['license-year'] ) ? $order_params['license-year'] : '';
									?>
                                    <div class="s-select-wrapper">
                                        <input type="hidden" id="tmp_license_year" name="tmp_license_year"
                                               value="<?php echo $selectedYear; ?>">
                                        <select name="license-year" id="license-year"
                                                data-max-year="<?php echo $max_year_by_seniority; ?> ">

											<?php echo '<option value="">בחר</option>'; ?>
                                        </select>

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
        <div class="card third-box">
            <div class="card-header" role="tab" id="headingThree">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center flex-wrap" data-toggle=""
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
                            <div class="col-md-6 justify-content-between">
                                <div class="row justify-content-between">
                                    <!-- Mobile phone number -->
	                                <?php
	                                sogo_do_input(
		                                'col-lg-10 mb-3 s-input-wrapper',
		                                'mobile-phone-number'
		                                , __( 'Mobile phone', 'sogoc' ),
		                                'text',
		                                '',
		                                isset( $order_params['mobile-phone-number'] ) ? $order_params['mobile-phone-number'] : '',
		                                $help_array
	                                );
	                                ?>

                                    <!-- Additional phone number -->
	                                <?php
	                                sogo_do_input(
		                                'col-lg-10 mb-3 s-input-wrapper',
		                                'additional-phone-number',
		                                __( 'Additional phone', 'sogoc' ),
		                                'text',
		                                '',
		                                isset( $order_params['additional-phone-number'] ) ? $order_params['additional-phone-number'] : '',
		                                $help_array
	                                );
	                                ?>

                                    <!-- Email -->
	                                <?php
	                                sogo_do_input(
		                                'col-lg-10 mb-3 s-input-wrapper',
		                                'email',
		                                __( 'Email', 'sogoc' ),
		                                'text',
		                                '',
		                                isset( $order_params['email'] ) ? $order_params['email'] : '',
		                                $help_array
	                                );
	                                ?>

                                </div>

                            </div>
                            <div class="col-md-6 justify-content-between">
                                <div class="row justify-content-end">
                                    <!-- City -->
	                                <?php
	                                sogo_do_input_2( 'col-lg-10 mb-3 s-input-wrapper', 'city', __( 'City', 'sogoc' ), 'text', '', $order_params['order_details']['city'], $help_array );
	                                ?>

	                                <?php
	                                sogo_do_input(
		                                'col-lg-10 mb-3 s-input-wrapper',
		                                'street',
		                                __( 'Street', 'sogoc' ),
		                                'text',
		                                '',
		                                isset( $order_params['street'] ) ? $order_params['street'] : '',
		                                $help_array
	                                );
	                                ?>


                                    <!-- House number -->
	                                <?php
	                                sogo_do_input(
		                                'col-lg-10 mb-3 s-input-wrapper',
		                                'house-number',
		                                __( 'House number', 'sogoc' ),
		                                'text',
		                                '',
		                                isset( $order_params['house-number'] ) ? $order_params['house-number'] : '',
		                                $help_array
	                                );
	                                ?>

                                    <!-- Apartment number -->
	                                <?php
	                                sogo_do_input(
		                                'col-lg-10 mb-3 s-input-wrapper',
		                                'apartment-number',
		                                __( 'Apartment number', 'sogoc' ),
		                                'text',
		                                '',
		                                isset( $order_params['apartment-number'] ) ? $order_params['apartment-number'] : '',
		                                $help_array
	                                );
	                                ?>
                                </div>
                            </div>
                        </div>

                        <!-- ROW -->
                        <div class="row justify-content-between d-none">

         <!--                   <!-- Mobile phone number -->
							<?php
/*							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'mobile-phone-number'
								, __( 'Mobile phone', 'sogoc' ),
								'text',
								'',
								isset( $order_params['mobile-phone-number'] ) ? $order_params['mobile-phone-number'] : '',
								$help_array
							);
							*/?>

                            <!-- Email -->
							<?php
/*							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'email',
								__( 'Email', 'sogoc' ),
								'text',
								'',
								isset( $order_params['email'] ) ? $order_params['email'] : '',
								$help_array
							);
							*/?>

                            <!-- Additional phone number -->
							<?php
/*							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'additional-phone-number',
								__( 'Additional phone', 'sogoc' ),
								'text',
								'',
								isset( $order_params['additional-phone-number'] ) ? $order_params['additional-phone-number'] : '',
								$help_array
							);
							*/?>

                            <!-- City -->
							<?php
/*							sogo_do_input_2( 'col-lg-5 mb-3 s-input-wrapper', 'city', __( 'City', 'sogoc' ), 'text', '', $order_params['order_details']['city'], $help_array );
							*/?>

                            <!-- Street -->
							<?php
/*							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'street',
								__( 'Street', 'sogoc' ),
								'text',
								'',
								isset( $order_params['street'] ) ? $order_params['street'] : '',
								$help_array
							);
							*/?>


                            <!-- House number -->
							<?php
/*							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'house-number',
								__( 'House number', 'sogoc' ),
								'text',
								'',
								isset( $order_params['house-number'] ) ? $order_params['house-number'] : '',
								$help_array
							);
							*/?>


                            <!-- Apartment number -->
							<?php
/*							sogo_do_input(
								'col-lg-5 mb-3 s-input-wrapper',
								'apartment-number',
								__( 'Apartment number', 'sogoc' ),
								'text',
								'',
								isset( $order_params['apartment-number'] ) ? $order_params['apartment-number'] : '',
								$help_array
							);
							*/?>

                            <!-- Terms & conditions 1 -->
                            <div class="col-lg-12">

                                <div class="form-group">

									<?php if ( array_key_exists( 'use-another-address', $help_array ) ): ?>
										<?php sogo_include_tooltip( 'use-another-address', $help_array, __( 'Use different shipping address', 'sogoc' ), $help_array['use-another-address'] ); ?>
									<?php endif; ?>


                                    <input type="checkbox" name="use-another-address"
                                           class="form-control use-another-address opacity-0"
                                           id="use-another-address"
										<?php echo( isset( $order_params['use-another-address'] ) && $order_params['use-another-address'] === 'on' ? 'checked' : '' ) ?>
                                    />


                                    <label for="use-another-address"
                                           class="d-flex align-items-center checkbox-label text-5 color-6 flex-wrap">

                                        <span class="font-09em"><?php _e( 'Use different shipping address', 'sogoc' ); ?></span>

                                    </label>

                                </div>

                            </div>
                            <div class="col-lg-12">
                                <div class="<?php echo( isset( $order_params['use-another-address'] ) && ! empty( $order_params['use-another-address'] ) ? '' : ' d-none ' ) ?> another-address">
                                    <div class="row justify-content-between extra-field-box">
                                        <!-- City -->
                                        <div class="col-lg-5 mb-3 s-input-wrapper">

                                            <label for="city-another" class="text-5 color-6 d-block mb-1">עיר</label>

                                            <input name="city-another" class="w-100 city-another"
                                                   value="<?php echo isset( $order_params['city-another'] ) ? $order_params['city-another'] : '' ?>"
                                                   type="text">

                                        </div>
                                        <div class="col-lg-5 mb-3 s-input-wrapper">

                                            <label for="street-another" class="text-5 color-6 d-block mb-1">רחוב</label>

                                            <input name="street-another" class="w-100 street-another"
                                                   value="<?php echo isset( $order_params['street-another'] ) ? $order_params['street-another'] : '' ?>"
                                                   type="text">

                                        </div>
                                        <div class="col-lg-5 mb-3 s-input-wrapper">

                                            <label for="house-number-another"
                                                   class="text-5 color-6 d-block mb-1 house-number-another">בית</label>

                                            <input name="house-number-another" class="w-100 house-number-another"
                                                   value="<?php echo isset( $order_params['house-number-another'] ) ? $order_params['house-number-another'] : '' ?>"
                                                   type="text">

                                        </div>
                                        <div class="col-lg-5 mb-3 s-input-wrapper">

                                            <label for="apartment-number-another"
                                                   class="text-5 color-6 d-block mb-1 apartment-number-another">דירה</label>

                                            <input name="apartment-number-another"
                                                   class="w-100 apartment-number-another"
                                                   value="<?php echo isset( $order_params['apartment-number-another'] ) ? $order_params['apartment-number-another'] : '' ?>"
                                                   type="text">

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
		<?php
		$allowedNumberDrivers = $order_params['order_details']['drive-allowed-number'];
		// $className = (+$allowedNumberDrivers === 1 ? ' d-none skip ': '');
		?>
        <!-- TAB 4 -->
        <div id="tab4-drivers" class="card drivers-card" data-allowed="<?php echo $allowedNumberDrivers; ?>">
            <div class="card-header" role="tab" id="headingFour">
                <h5 class="mb-0 text-5">
                    <a class="collapsed d-flex align-items-center flex-wrap" data-toggle=""
                       data-parent="#insurance-accordion"
                       href="#collapseFour"
                       aria-expanded="false" aria-controls="collapseThree">

                        <i class="icon-check-01-colorwhite icon-x2 ml-1 d-none"></i>

						<?php _e( 'Driver details', 'sogoc' ); ?>

                        <div class="d-flex flex-wrap selected-header-box"></div>

                    </a>
                </h5>
            </div>
			<?php

			//            echo '<pre style="direction: ltr;">';
			//            var_dump($order_params);
			//            echo '</pre>';
			?>
            <div id="collapseFour" class="collapse content-top  " role="tabpanel" aria-labelledby="headingFour">
                <div class="card-block mb-3">

                    <!-- CONTAINER-FLUID -->
                    <div class="container-fluid">

                        <!-- ROW -->
                        <div class="" id="allowed_to_drive"
                             data-allowed="<?php echo $order_params['order_details']['drive-allowed-number'] ?>">
							<?php
							$countDrivers = ( (int) $order_params['order_details']['drive-allowed-number'] === 4 ? 1 : (int) $order_params['order_details']['drive-allowed-number'] );
							?>
							<?php if ( $countDrivers >= 1 ) : ?>

								<?php

								$carOwnerIsAdriver = (int) $order_params['drive-allowed'];
								$genderIdCounter   = 0;

								//prevent wrong count of extra drivers boxes if car owner is driving to
//								if ($carOwnerIsAdriver === 1) {
//									$countDrivers = $countDrivers-1;
//								}

								for ( $i = 0; $i <= (int) $countDrivers - 1; $i ++ ) :

									$border = $i > 0 ? '  border-top color-2 pt-4 ' : '';
									$class         = '';
									if ( $i === (int) $countDrivers - 1 && $carOwnerIsAdriver === 1 ) {
										$class = ' d-none';
									}

									?>

                                    <div class=" row justify-content-between driver-box  <?php echo $border . $class ?>">
										<?php

										if ( ! $genderIdCounter ) {
											$genderIdCounter = ( $i + 1 );
										}
										?>

                                        <!-- Driver first name -->
										<?php
										sogo_do_input_1(
											'col-lg-5 mb-3 s-input-wrapper',
											'driver-first-name',
											__( 'First name', 'sogoc' ),
											'text',
											'',
											isset( $order_params['driver-first-name'][ $i ] ) ? $order_params['driver-first-name'][ $i ] : '',
											$help_array
										);
										?>


                                        <!-- Driver last name -->
										<?php
										sogo_do_input_1(
											'col-lg-5 mb-3  s-input-wrapper',
											'driver-last-name',
											__( 'Last name', 'sogoc' ),
											'text',
											'',
											isset( $order_params['driver-last-name'][ $i ] ) ? $order_params['driver-last-name'][ $i ] : '',
											$help_array
										);
										?>


                                        <!-- Identical number (ID) -->
										<?php
										sogo_do_input_1(
											'col-lg-5 mb-3 s-input-wrapper',
											'driver-identical-number',
											__( 'Identical number', 'sogoc' ),
											'text',
											'',
											isset( $order_params['driver-identical-number'][ $i ] ) ? $order_params['driver-identical-number'][ $i ] : '',
											$help_array


										);
										?>


                                        <!-- Choose birth date -->
                                        <div class="col-lg-5 s-input-wrapper date-wrapper">

											<?php if ( array_key_exists( 'driver-birthday', $help_array ) ): ?>
												<?php sogo_include_tooltip( 'driver-birthday', $help_array, __( 'Driver birthday', 'sogoc' ), $help_array['driver-birthday'] ); ?>
											<?php endif; ?>

                                            <label for="driver-birthday"
                                                   class="text-5 color-6"><?php _e( 'Driver birthday', 'sogoc' ); ?></label>

                                            <div class="form-group date-picker mb-0 ">

                                                <input type="text" data-index="<?php echo $i; ?>"
                                                       id="driver-birthday-<?php echo $i ?>" readonly="readonly"
                                                       name="driver-birthday[]"
                                                       data-start="<?php echo $start_birthday; ?>"
                                                       value="<?php echo( isset( $order_params['driver-birthday'][ $i ] ) && ! empty( $order_params['driver-birthday'][ $i ] ) ? $order_params['driver-birthday'][ $i ] : '' ) ?>"
                                                       class="w-100 medium driver-birthday extra-driver-info datepicker"/>
                                            </div>




                                        </div>

                                        <!-- Driver's gender -->
                                        <div class="col-lg-5 mb-3 s-input-wrapper">

                                            <div class="s-radio-wrapper">

                                                <label class="text-5 color-6 d-block mb-1">
													<?php _e( 'Driver\'s gender', 'sogoc' ); ?>
                                                </label>

                                                <div class="d-flex">

                                                    <input type="radio" class="form-radio-input opacity-0 p-absolute"
                                                           name="driver-gender[<?php echo $i; ?>]"
                                                           id="driver-gender-<?php echo $genderIdCounter; ?>" value="1"
														<?php echo ( isset( $order_params['driver-gender'][ $i ] ) && $order_params['driver-gender'][ $i ] === '1' ) ? 'checked' : '' ?>
                                                           data-val="male">
                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                           for="driver-gender-<?php echo $genderIdCounter ++ ?>">
														<?php _e( 'Male', 'sogoc' ); ?>
                                                    </label>

                                                    <input type="radio" class="form-radio-input opacity-0"
                                                           name="driver-gender[<?php echo $i; ?>]"
														<?php echo ( isset( $order_params['driver-gender'][ $i ] ) && $order_params['driver-gender'][ $i ] === '2' ) ? 'checked' : '' ?>
                                                           id="driver-gender-<?php echo $genderIdCounter; ?>" value="2"
                                                           data-val="female">
                                                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"
                                                           for="driver-gender-<?php echo $genderIdCounter ++ ?>">
														<?php _e( 'Female', 'sogoc' ); ?>
                                                    </label>

                                                </div>

                                            </div>


                                        </div>

                                        <!-- Years of issuing license -->
										<?php
										//                            sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'years-issuing-license', __( 'Year of issuing a license', 'sogoc' ), 'text', '', true );
										?>
                                        <div class="col-lg-5 mb-3 driver-license-box">
											<?php if ( array_key_exists( 'years-issuing-license', $help_array ) ): ?>
												<?php sogo_include_tooltip( 'years-issuing-license', $help_array, __( 'Year of issuing a license', 'sogoc' ), $help_array['years-issuing-license'] ); ?>
											<?php endif; ?>
                                            <label for=""
                                                   class="text-5 color-6 d-inline-block mb-1"><?php echo _e( 'Year of issuing a license', 'sogoc' ); ?></label>

                                            <div class="s-select-wrapper">

                                                <select name="years-issuing-license[]"
                                                        data-max-year="<?php echo $max_year_by_seniority; ?>">

                                                    <option value="">בחר</option>
													<?php if ( isset( $order_params['years-issuing-license'][ $i ] ) && ! empty ( $order_params['years-issuing-license'][ $i ] ) ) : ?>
                                                        <option value="<?php echo $order_params['years-issuing-license'][ $i ]; ?>"
                                                                selected>
															<?php echo $order_params['years-issuing-license'][ $i ]; ?>
                                                        </option>
													<?php endif; ?>
                                                </select>

                                            </div>
                                        </div>

                                    </div>
								<?php endfor; ?>
							<?php endif; ?>

                        </div>
                        <p data-lowest-seniority="<?php echo @$order_params['order_details']['lowest-seniority']; ?>"
                           data-youngest-driver-age="<?php echo @$order_params['order_details']['youngest-driver']; ?>"
                           id="drivers_tab_message"></p>

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
									$checked              = '';
									$upsalesChosePrices   = 0;//if order was edited we catch prices of chosen upsales

									if ( ! $insType ) {
										$insType = trim( strip_tags( $_GET['i_type'] ) );
									}

									?>

									<?php if ( have_rows( 'insurance_upsales', 'options' ) ) : ?>

                                        <div class="col-lg-6 upsales-default">
											<?php while ( have_rows( 'insurance_upsales', 'options' ) ): the_row(); ?>
												<?php

												if ( $order_params[ 'upsale_' . get_sub_field( 'upsale_sku' ) ] === 'on' ) {
													$checked             = ' checked ';
													$upsalesChosenPrices += (int) get_sub_field( 'upsales_price' );
												}


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
												<?php if ( get_sub_field( 'insurance_type' ) == $insType ) : ?>

                                                    <div class="upsales-box form-group mb-2"
                                                         id="upsales_box_<?php echo $index; ?>"
                                                         data-id="<?php echo $index; ?>">

                                                        <input type="checkbox"
															<?php echo $checked; ?>
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

								<?php sogo_do_continue_btn('upsales-btn'); ?>

                            </div>

                        </div>

                    </div>

                </div>


            </div>
        </div>

        <!-- TAB 6 -->
        <div class="card">
            <div class="card-header p-0" role="tab" id="headingSix">
                <h5 class="mb-0 text-5 price-tab-title">
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

            <div id="collapseSix" class="collapse content-top " role="tabpanel" aria-labelledby="headingSix">
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
										<?php sogo_include_tooltip( 'use-phone-payment', $help_array, __( 'Use phone payment', 'sogoc' ), $help_array['use-phone-payment'] ); ?>
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


                                        <!-- Identical number (ID) of cardholder -->
										<?php
										sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'cardholder-id', __( 'Cardholder ID', 'sogoc' ), 'text' );
										?>


                                        <!-- Number of credit card -->
										<?php
										sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'card-number', __( 'Number of credit card', 'sogoc' ), 'text' );
										?>


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

                                        $num_payments_no_percents = $mandatory_num_payments = $other_payment_payments = 0;

                                        if (preg_match('/,/', $order_params['order_details']['company_id'])) {

                                            //0 = id of mandatory company
                                            //1 = id of third party company
                                            $id                     = explode(',', $order_params['order_details']['company_id'])[0];
                                            $id_third_party_company = explode(',', $order_params['order_details']['company_id'])[1];

	                                        $order_params['order_details']['company_id'] = $id;
                                        } else {
	                                        $id_third_party_company = $order_params['order_details']['company_id'];
                                        }
										?>


                                        <input type="hidden"
                                               name="num-payments-no-percents"
                                               id="num-payments-no-percent"
                                               value="<?php echo (int) $companies_settings[ $id_third_party_company ]['num_payments_no_percents']; ?>">
                                        <!-- Number of payments for mandatory  -->
                                        <div class="col-lg-5 mb-3">
											<?php

											$mandatory_payments = (int) $companies_settings[ $order_params['order_details']['company_id'] ]['mandatory_num_payments'];
											$mandatory_payments = $mandatory_payments > 0 ? $mandatory_payments : 8;
											$mandat_array       = array();

											for ( $i = 1; $i <= $mandatory_payments; $i ++ ) {
												$mandat_array[ $i ] = $i;
											}

											sogo_do_select( __( 'Number of payments for mandatory', 'sogoc' ), 'mandat-num-payments', $mandat_array, '', '', '', '', '', $help_array );
											?>

                                        </div>
										<?php if ( ! empty( $order_params['order_details']['price_havila'] ) && $order_params['order_details']['price_havila'] > 0 && (int) $order_params['order_details']['in_type'] !== 1 ): ?>
                                            <!-- Number of payments for comprehensive/third party  -->
                                            <div class="col-lg-5 mb-3">
												<?php

												$havila_payment_payments = (int) $companies_settings[ $id_third_party_company ]['havila_num_payments'];
												$havila_payment_payments = $havila_payment_payments > 0 ? $havila_payment_payments : 2;
												$havila_payment_array    = array();

												for ( $i = 1; $i <= $havila_payment_payments; $i ++ ) {
													$havila_payment_array[ $i ] = $i;
												}


												sogo_do_select( __( 'Number of payments for comprehensive', 'sogoc' ), 'havila-num-payments', $havila_payment_array, '', '', '', '', '', $help_array );

												?>


                                            </div>
										<?php endif;
										//									    echo '<pre style="direction: ltr;">';
										//									    var_dump($order_params['order_details']['insurance-type']);
										//									    echo '</pre>';
										?>


										<?php if ( ! empty( $order_params['order_details']['insurance-type'] ) && $order_params['order_details']['second_price'] && (int) $order_params['order_details']['in_type'] !== 1 ): ?>
                                            <!-- Number of payments for comprehensive/third party  -->
                                            <div class="col-lg-5 mb-3">
												<?php

												if (isset($id_third_party_company) && is_numeric($id_third_party_company)) {

													$order_params['order_details']['company_id'] = $id_third_party_company;
												} else {
													$order_params['order_details']['company_id'] = $order_params['order_details']['company_id'];
                                                }

												$other_payment_payments = (int) $companies_settings[ $order_params['order_details']['company_id'] ]['other_num_payments'];
												$other_payment_payments = $other_payment_payments > 0 ? $other_payment_payments : 8;
												$other_payment_array    = array();

												for ( $i = 1; $i <= $other_payment_payments; $i ++ ) {
													$other_payment_array[ $i ] = $i;
												}

												$titleForPayments = ( (int) $insType === 2 ? __( 'Number of payments for comprehensive', 'sogoc' ) :
													( (int) $insType === 3 ? __( 'Number of payments for thirdParty', 'sogoc' ) : '' ) );

												//											    if ( (int)$insType === 3) {
												//												    sogo_do_select( $titleForPayments, 'other-num-payments', $other_payment_array, '', '', '','','',$help_array );
												//                                                }


												sogo_do_select( $titleForPayments, 'other-num-payments', $other_payment_array, '', '', '', '', '', $help_array );

												?>

                                            </div>
										<?php endif; ?>

                                        <div class="col-lg-5 mb-3 <?php echo( (int) $upsalesChosenPrices === 0 || is_null( $upsalesChosePrices ) ? ' d-none ' : ' ' ) ?>"
                                             id="upsales_number_payments">
											<?php
											$upsales_payment_payments = (int) $companies_settings[ $order_params['order_details']['company_id'] ]['upsales_number_payments'];
											$upsales_payment_payments = $upsales_payment_payments > 0 ? $upsales_payment_payments : 2;
											$upsales_payment_array    = array();

											for ( $i = 1; $i <= $upsales_payment_payments; $i ++ ) {
												$upsales_payment_array[ $i ] = $i;
											}

											if ( isset( $order_params['upsales-price'] ) && empty( $order_params['upsales-price'] ) ) {
												$order_params['upsales-price'] = $upsalesChosenPrices;
											}

											sogo_do_select( __( 'Number of payments for upsales', 'sogoc' ), 'upsales-number-payments', $upsales_payment_array, '', '', '', '', '', $help_array );
											?>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="ins-company"
                           value="<?php echo $order_params['order_details']['ins_company']; ?>">
                    <input type="hidden" name="mandat-price"
                           value="<?php echo $order_params['order_details']['mandat_price']; ?>">
					<?php
					if ( isset( $order_params['order_details']['price_havila'] ) && $order_params['order_details']['price_havila'] > 0 ) {
						$price = intval( $order_params['order_details']['second_price'] ) - intval( $order_params['order_details']['price_havila'] );
					} else {
						$price = $order_params['order_details']['second_price'];
					}
					?>
                    <input type="hidden" name="second-price"
                           value="<?php echo (int) $order_params['order_details']['in_type'] !== 1 ? $price : ''; ?>">
                    <input type="hidden" name="old-price" value="<?php echo $price; ?>">
                    <input type="hidden" name="package-price"
                           value="<?php echo (int) $order_params['order_details']['in_type'] !== 1 ? $order_params['order_details']['price_havila'] : ''; ?>">
                    <input type="hidden" name="upsales-price" id="upsales_price"
                           value="<?php echo( $upsalesChosenPrices !== 0 ? $upsalesChosenPrices : '' ) ?>">

                    <!-- CONTAINER-FLUID -->
                    <div class="container-fluid mb-3">


                        <!-- ROW -->
                        <div class="row justify-content-between d-none">
                            <!-- Drive on saturday -->
                            <div class="col-lg-5 mb-3">

                                <div class="s-radio-wrapper">

                                    <!-- tooltip -->
									<?php if ( array_key_exists( 'policy-send', $help_array ) ): ?>
										<?php sogo_include_tooltip( 'policy-send', $help_array, __( 'Policy send', 'sogoc' ), $help_array['policy-send'] ); ?>
									<?php endif; ?>

                                    <label class="text-5 color-6 d-inline-block mb-1">
										<?php _e( 'Policy send', 'sogoc' ); ?>
                                    </label>

                                    <div class="d-flex">

										<?php

										$check1 = $order_params['policy-send'] == '1' ? 'checked' : '';
										$check2 = $order_params['policy-send'] == '2' ? 'checked' : '';
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
                                           class="d-flex align-items-center checkbox-label text-6 color-6 flex-wrap">

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

                                    <button type="submit" data-link="<?php echo $link; ?>"
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

    <!--    <div class="row driver-box justify-content-between border-top border-width-x1 pt-3">-->
    <!---->
    <!--        <!-- Driver first name -->-->
    <!--		--><?php
	//		sogo_do_input_1( 'col-lg-5 mb-3 s-input-wrapper', 'driver-first-name', __( 'First name', 'sogoc' ), 'text' );
	//		?>
    <!---->
    <!--        <!-- Driver last name -->-->
    <!--		--><?php
	//		sogo_do_input_1( 'col-lg-5 mb-3 s-input-wrapper', 'driver-last-name', __( 'Last name', 'sogoc' ), 'text' );
	//		?>
    <!---->
    <!--        <!-- Identical number (ID) -->
    <!--		--><?php
	//		sogo_do_input_1( 'col-lg-5 mb-3 s-input-wrapper', 'driver-identical-number', __( 'Identical number', 'sogoc' ), 'text' );
	//		?>
    <!---->
    <!--        <!-- Choose birth date -->
    <!--        <div class="col-lg-5 s-input-wrapper date-wrapper">-->
    <!---->
    <!--            <div class="form-group date-picker mb-0 hidden-md-down">-->
    <!--                <label-->
    <!--                        class="text-5 color-6">--><?php //_e( 'Driver birthday', 'sogoc' ); ?><!--</label>-->
    <!--                <input type="text" readonly="readonly" name="driver-birthday[]"-->
    <!--                       class="w-100 medium datepicker driver-birthday extra-driver-info"/>-->
    <!--            </div>-->
    <!---->
    <!--            <div class="form-group mb-0 hidden-lg-up">-->
    <!---->
    <!--                <div class="datepicker static-datepicker"></div>-->
    <!---->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
    <!---->
    <!--        <!-- Driver's gender -->-->
    <!--        <div class="col-lg-5 mb-3 s-input-wrapper">-->
    <!---->
    <!--            <div class="s-radio-wrapper">-->
    <!---->
    <!--                <label class="text-5 color-6 d-block mb-1">-->
    <!--					--><?php //_e( 'Driver\'s gender', 'sogoc' ); ?>
    <!--                </label>-->
    <!---->
    <!--                <div class="d-flex gender-input">-->
    <!---->
    <!--                    <input type="radio" class="form-radio-input opacity-0 p-absolute"-->
    <!--                           name="driver-gender-3" value="1"-->
    <!--                           data-val="male">-->
    <!--                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"-->
    <!--                           for="">-->
    <!--						--><?php //_e( 'Male', 'sogoc' ); ?>
    <!--                    </label>-->
    <!---->
    <!--                    <input type="radio" class="form-radio-input opacity-0"-->
    <!--                           name="driver-gender-3" value="2"-->
    <!--                           data-val="female">-->
    <!--                    <label class="form-radio-label radio-btn-style p-relative text-5 flex-grow-1"-->
    <!--                           for="">-->
    <!--						--><?php //_e( 'Female', 'sogoc' ); ?>
    <!--                    </label>-->
    <!---->
    <!--                </div>-->
    <!---->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
    <!---->
    <!--        <!-- Years of issuing license -->-->
    <!--        <div class="col-lg-5 mb-3 driver-license-box">-->
    <!--            <label for=""-->
    <!--                   class="text-5 color-6 d-block mb-1">-->
	<?php //echo _e( 'Year of issuing a license', 'sogoc' ); ?><!--</label>-->
    <!---->
    <!--            <div class="s-select-wrapper">-->
    <!---->
    <!--                <select name="years-issuing-license[]" data-max-year="-->
	<?php //echo $max_year_by_seniority; ?><!--">-->
    <!---->
    <!--                    <option value="">בחר</option>-->
    <!--                </select>-->
    <!---->
    <!--            </div>-->
    <!--        </div>-->
    <!--		--><?php
	//		//TODO: prepare data of years
	//		//        sogo_do_input( 'col-lg-5 mb-3 s-input-wrapper', 'years-issuing-license', __( 'Year of issuing a license', 'sogoc' ), 'text', '', true );
	//		?>
    <!---->
    <!--    </div>-->

</div>
