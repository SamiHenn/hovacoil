<!-- FOREACH -->
<div class="insurance-cube pt-1 px-2" <?php if($cube_index - $cube_empties_total == 1) echo 'style="border-color: #006fc0"';?>>
    <div class="cube_for_mail" data-insuranse_type="<?=$_POST['insurance-type']?>">
        <!-- ROW -->
        <div class="row">
            <div class="col-lg-12 text-lg-right">
                <!-- TITLE -->
                <!-- sami - show the first company name -->
				<!--<?php // if($cube_index - $cube_empties_total == 1) echo '<span class="text-6 medium color-3 v-align-top">&nbsp;</span>'; ?>-->
                <span class="text-6 medium color-3 ins-company v-align-top <!--<?php // if($cube_index - $cube_empties_total == 1) echo 'd-none';?>-->">
    <!--                    --><?php
	                echo '<pre style="direction: ltr;">';
	                //var_dump($insurance_cube);die;
	                echo '</pre>';
                    ?>
                            <?php echo $insurance_cube['company'];  ?>

    <!--                    --><?php //else: ?>
    <!--                    --><?php //endif; ?>
                    </span>
            </div>
        </div>

        <!-- TOP PART -->

        <!-- ROW -->
        <div class="row mb-1">

            <!-- TOP RIGHT PART -->
            <div class="col-7 col-lg-3">

                <!-- TITLE -->
                <span class="text-6 color-6 d-inline-block v-align-top">
                        <?php if ( isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'MAKIF' || $_GET['insurance-type'] == 'ZAD_G' ) ): ?>
                            <?php if ( $_GET['insurance-type'] == 'MAKIF' ): ?>
                                ביטוח מקיף וחובה
                            <?php else: ?>
                                ביטוח צד ג וחובה
                            <?php endif; ?>
                        <?php else: ?>
                            ביטוח חובה
                        <?php endif; ?>
                    </span>

                <!-- PRICE -->
				<!-- sami add dmei tipul for hova only -->
                    <?php if ( isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'HOVA') )
{
	$dmeiTipul = 60;
}
				else
				{
	$dmeiTipul = 0;	
				}
				?>                <div>
                    <span title="<?php echo $insurance_cube['company'];?>" class="text-6 color-6">סה"כ</span>
                    <?php if ( isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'MAKIF' || $_GET['insurance-type'] == 'ZAD_G' ) ): ?>
                        <span class="text-2 color-3 medium total"><?php echo number_format(( (int) $insurance_cube['mandatory'] + (int) $insurance_cube['comprehensive'] )); ?></span>
                    <?php else: ?>
                        <span class="text-2 color-3 medium total">
                                <?php
                                $price = intval( preg_replace( '/[^\d.]/', '', $insurance_cube['price'] ) ); ?>
                                <?php //echo $insurance_cube['price']; ?>
                                <?php echo number_format($price + $dmeiTipul); ?>
                        </span>
                    <?php endif; ?>
                    <span class="text-p color-3 medium">&#8362;</span>
                </div>
                <?php if ( isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'MAKIF' || $_GET['insurance-type'] == 'ZAD_G' ) ): ?>
                    <!-- META DATA -->
                    <div class="mb-1">
                        <span class="text-6 color-6 regular mandat-price"><?php echo __( 'Mandatory', 'sogoc' ) . ': <span>' . $insurance_cube['mandatory']; ?></span>
                        <?php if ( $_GET['insurance-type'] == 'MAKIF' ): ?>
                            <span class="text-6 color-6 regular second-price"><?php echo __( 'Comprehensive', 'sogoc' ) . ': <span>' . $insurance_cube['comprehensive']; ?></span>
                        <?php else: ?>
                            <span class="text-6 color-6 regular second-price"><?php echo __( 'Third party', 'sogoc' ) . ': <span>' . $insurance_cube['comprehensive']; ?></span>
                        <?php endif; ?>
                    </div>
                   <!-- <div>
                        <div>
                            <h6 class="text-6 color-3">מספר תשלומים לפי ביטוח</h6>
                        </div>
                        <span class="text-p color-6 regular d-inline-block"><?php /*echo __( 'Mandatory', 'sogoc' );*/?>: <?php /*echo sogo_get_mandatory_company_payments($insurance_cube['company']);*/?></span>
                        <span class="text-p color-6 regular d-inline-block"><?php /*echo $_GET['insurance-type'] == 'MAKIF' ? __( 'Comprehensive', 'sogoc' ) : __( 'Third party', 'sogoc' );*/?>: <?php /*echo sogo_get_comprehensive_company_payments($insurance_cube['company']);*/?></span>
                    </div>-->
                <?php else: ?>
                    <div class="mb-1">
                        <?php


                        //if company name different between from crm and client view we change it to crm view for get the number payments
                       $company  = ($insurance_cube['company'] !== 'פיקס' ? $insurance_cube['company'] : 'שלמה');
                        ?>
                        <span class="text-p color-6 regular d-inline-block"> עד : <?php echo sogo_get_mandatory_company_payments($company);?> תשלומים ללא ריבית <?php //echo __( 'Mandatory', 'sogoc' );?></span>
                    </div>
                <?php endif; ?>
            </div>


            <!-- TOP LEFT PART - protection -->
            <div class="col-5 col-lg-9 pr-lg-3 <?php if($_GET['insurance-type'] == 'MAKIF') echo 'border-right border-color-3';?>">

                <?php
                $insurance_protection_text = "אין מידע - נדרש לבדוק";

                $company_id = absint( $insurance_cube['company_id'] );

                if ( isset( $companies[ $company_id ] ) ) {

	                if(is_array($companies[ $company_id ]['protection'])){
	                    foreach ($companies[ $company_id ]['protection'] as $protection){
		                    if ( (int) $protection['protection_code'] === (int) $insurance_cube['protect_id'] ) {
			                    $insurance_protection_text = $protection['protection_text'];
			                    break;
		                    }
                        }
                    }

                }

                ?>

                <?php if ( isset( $_GET['insurance-type'] ) &&  $_GET['insurance-type'] == 'MAKIF' ): ?>
                    <!-- MIDDLE TEXT -->
                    <div class="line-height-1 protect" data-protect="<?php echo $insurance_cube['protect_id']; ?>">

                        <span class="text-6 color-6 d-block line-height-1-3">מיגון נדרש:</span>

                        <span class="text-6 color-6 regular"><?php echo $insurance_protection_text; ?></span>

                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <!-- ROW -->

    <div class="row">

        <div class="col lg-12">

            <!-- middle modal -->
            <div id="accordion-<?php echo $cube_index; ?>" role="tablist" aria-multiselectable="true">
                <div class="proposal-details">

                    <!-- ROW -->
                    <div class="row">

                        <div class="col-lg-12">

                            <div id="collapseOne-<?php echo $cube_index; ?>" class="collapse" role="tabpanel"
                                 aria-labelledby="headingOne">

                                <div class="" role="tab" id="headingOne-<?php echo $cube_index; ?>">
                                    <h5 class="mb-0 text-5 color-6">
                                        <?php _e( 'Proposal details', 'sogoc' ); ?>
                                    </h5>
                                </div>

                                <div class="proposal-details-content">

                                    <div class="d-flex">
                                        <?php
                                            $additionalInfo = '';
                                            $in_type        = (int)$_POST['in_type'];

                                        if(isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'MAKIF')){
                                            $details_params = array();

	                                        $code_levi = sogo_get_levi_code();

	                                        //remove all leading zeros from levi code
	                                        $code_levi = ltrim($code_levi);

	                                        //if code levi length is 7 its commercial vehicle type, else its private
	                                        $vehicle_type_by_levi = strlen($code_levi);
                                            $details_params['insurance_period']  =  $_POST['insurance_period'] ;
                                            $details_params['insurance_company'] = $insurance_cube['company_id'];
                                            $details_params['vehicle_type']      = $vehicle_type_by_levi != 7 ? 'פרטי' : 'מסחרי';
                                            $details_params['from_age']          = (int)$_POST['youngest-driver'];
                                            $details_params['to_age']            = (int)$_POST['youngest-driver'];
                                            $details_params['from_seniority']    = (int)$_POST['lowest-seniority'];
                                            $details_params['to_seniority']      = (int)$_POST['lowest-seniority'];
                                            $offer_details = sogo_get_insurance_terms( $details_params );

                                            $text = apply_filters('the_content', $offer_details[0]['message']);
	                                        $additionalInfo = $text;
	                                        $insurance_cube['message'] = '('.$insurance_cube['protect_id'].') ' .$additionalInfo;
                                            echo $text;

                                        }
                                        elseif ($_GET['insurance-type'] == 'ZAD_G'){
                                            echo  $insurance_cube['message'];
                                        }
                                        elseif ($_GET['insurance-type'] == 'HOVA'){ ?>
                                            <div class="d-block col-lg-12">
                                                <?php echo $insurance_cube['additional_hova'] ;
												if (empty($insurance_cube['additional_hova']))
												{
												 include 'additionalHovaTerms.php';
												}
												?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>

    </div>
<?php

?>
    <!-- BOTTOM BUTTONS PART -->

    <!-- ROW -->
    <div class="row mb-2">

        <div class="col-lg-12 d-flex align-items-center justify-content-between">

            <!-- 3 BUTTONS PART -->
            <div>
				<?php if ( isset( $_GET['insurance-type'] ) ): ?>
<!--				--><?php //if ( isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'MAKIF' || $_GET['insurance-type'] == 'ZAD_G' ) ): ?>
                    <!-- MORE DETAILS BUTTON -->
                    <div class="d-inline-block cursor-pointer ml-lg-3 mb-1 mb-lg-0"
                         id="compare-show-more-details-<?php echo $cube_index; ?>">
                        <a data-toggle="collapse" data-parent="#accordion-<?php echo $cube_index; ?>"
                           class="compare-show-more-details-a"
                           href="#collapseOne-<?php echo $cube_index; ?>" aria-expanded="true"
                           aria-controls="collapseOne-<?php echo $cube_index; ?>">
                            <span class="custom-circle bg-2"><i
                                        class="icon-plus-01-colorwhite icon-x2 icon-x2 d-inline-block align-middle"></i></span>

                            <span class="text-custom-1 v-align-middle regular color-black">פרטים נוספים</span>
                        </a>
                    </div>
				<?php endif; ?>

                <!-- RECEIVE OFFER IN EMAIL -->
                <div class="d-inline-block cursor-pointer ml-lg-3 receive-offer-by-email mb-1 mb-lg-0"
                     id="receive-offer-by-email-<?php echo $cube_index; ?>">

                    <span class="custom-circle bg-5"><i
                                class="icon-envelope-01-colorwhite icon-x2 icon-x2 d-inline-block align-middle"></i></span>
                    <span class="text-custom-1 v-align-middle regular">קבל הצעה זו במייל</span>

                </div>

                <!-- LEAVE PHONE NUMBER 11-9-2022 sami changed next div from d-inline-block to d-none -->
				<?php if ( isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'MAKIF' || $_GET['insurance-type'] == 'ZAD_G' ) ): ?>
                <div class="d-none cursor-pointer receive-offer-by-phone"
                     id="receive-offer-by-phone-<?php echo $cube_index; ?>">

                    <span class="custom-circle bg-3"><i
                                class="icon-phone-01-colorwhite icon-x2 icon-x2 d-inline-block align-middle"></i></span>
                    <span class="text-custom-1 v-align-middle regular">דברו איתנו</span>

                </div>
<?php endif; ?>
			</div>

            <!-- BUY INSURANCE BUTTON -->
            <?php

            $text = isset($insurance_cube['message']) && !empty( $insurance_cube['message']) ?  htmlspecialchars($insurance_cube['message']) : $text ;
        //    $text =   htmlspecialchars($offer_details) ;


            ?>
            <div onclick="samiloader()">
                <a data-in-type="<?php echo $in_type?>"
                   data-company="<?php echo (isset($insurance_cube['mandatory_company_id']) ?  $insurance_cube['mandatory_company_id'] . ',' . $insurance_cube['company_id'] : $insurance_cube['company_id']);?>"
                   data-type="<?php echo !isset( $_GET['insurance-type'] ) ? 'use_main' : '';?>"
                   data-order="<?php echo $ins_order;?>"
                   data-aff="<?php echo $_SESSION['aff'] ?? 0;?>"
                   data-src="<?php echo $_SESSION['src'] ?? 0;?>"
                   data-package="<?php echo $insurance_cube['price_havila'];?>"
                   data-add-info="<?php echo esc_attr($text)?>"
                   href="<?php echo get_field('_sogo_extra_order_insurance', 'option')?>"
                   class="s-button-light s-button-2 buy-ins"
				   style="line-height: 40px"
                        id="buy-insurance-<?php echo $cube_index; ?>">
                    <span><?php _e( 'Purchase insurance', 'sogoc' ); ?></span>
                    <i class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>
                </a>
				<?php if($insurance_cube['company_id'] == 60)
{
	echo '<a href="#" onclick=window.open("';
	echo $insurance_cube['buyUrl'];
    echo '");return false; class="s-button-light s-button-2 buy-ins bg-3 border-color-3 mt-1" style="line-height: 40px">
                    <span>רכישה אונליין</span>
                    <i class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></i>
                </a>';
}
				?>
            </div>
        </div>
    </div>
    <!-- CONTACT US FORMS -->
	<?php include 'contact-us-1.php'; ?>
	<?php include 'contact-us-2.php'; ?>
</div>