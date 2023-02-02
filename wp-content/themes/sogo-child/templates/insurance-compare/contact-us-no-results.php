<!-- CONTACT US FORMS -->
<?php
//echo '<pre style="direction: ltr;">';
//var_dump($order_params['order_details']);
//echo '</pre>';
?>
<div class="contact-us-by-phone mt-3">

    <form action="" METHOD="post" class="contact-us-compare-form-phone-1 two" id="contact-us-compare-form-phone-<?php echo $cube_index; ?>">

        <?php foreach ($order_params['order_details'] as $param => $value) :?>
	        <input class="<?php echo $param;?>" name="<?php echo $param;?>" type="hidden" value="<?php echo $value;?>">
        <?php endforeach;?>
        <input class="subjectForLead" name="subjectForLead" type="hidden" value="אין תוצאות - <?php if ( isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'MAKIF' || $_GET['insurance-type'] == 'ZAD_G' ) ): ?>
<?php if ( $_GET['insurance-type'] == 'MAKIF' ): ?>
ביטוח מקיף וחובה
<?php else: ?>
ביטוח צד ג וחובה
<?php endif; ?>
<?php else: ?>
ביטוח חובה
<?php endif; ?>">

<!--        <input class="ins_order" name="ins_order" type="hidden" value="--><?php //echo isset($_GET['ins_order']) ? $_GET['ins_order'] : 'false';?><!--">-->
<!--        <input class="ins_link" name="ins_link" type="hidden" value="--><?php //echo $order_params['ins_link'];?><!--">-->
<!--        <input class="insurance-date-start" name="insurance-date-start" type="hidden" value="--><?php //echo $order_params['insurance-date-start'];?><!--">-->
<!--        <input class="insurance-date-finish" name="insurance-date-finish" type="hidden" value="--><?php //echo $order_params['insurance-date-finish'];?><!--">-->
<!--        <input class="vehicle-manufacturer" name="vehicle-manufacturer" type="hidden" value="--><?php //echo $order_params['vehicle-manufacturer'];?><!--">-->
<!--        <input class="vehicle-year" name="vehicle-year" type="hidden" value="--><?php //echo $order_params['vehicle-year'];?><!--">-->
<!--        <input class="vehicle-brand" name="vehicle-brand" type="hidden" value="--><?php //echo $order_params['vehicle-brand'];?><!--">-->
<!--        <input class="vehicle-sub-brand" name="vehicle-sub-brand" type="hidden" value="--><?php //echo $order_params['vehicle-sub-brand'];?><!--">-->
<!--        <input class="gears" name="gears" type="hidden" value="--><?php //echo $order_params['gears'];?><!--">-->
<!--        <input class="ownership" name="ownership" type="hidden" value="--><?php //echo $order_params['ownership'];?><!--">-->
<!--        <input class="keeping-distance-system" name="keeping-distance-system" type="hidden" value="--><?php //echo $order_params['keeping-distance-system'];?><!--">-->
<!--        <input class="deviation-system" name="deviation-system" type="hidden" value="--><?php //echo $order_params['deviation-system'];?><!--">-->
<!--        <input class="youngest-driver" name="youngest-driver" type="hidden" value="--><?php //echo $order_params['youngest-driver'];?><!--">-->
<!--        <input class="lowest-seniority" name="lowest-seniority" type="hidden" value="--><?php //echo $order_params['lowest-seniority'];?><!--">-->
<!--        <input class="drive-allowed-number" name="drive-allowed-number" type="hidden" value="--><?php //echo $order_params['drive-allowed-number'];?><!--">-->
<!--        <input class="gender" name="gender" type="hidden" value="--><?php //echo $order_params['gender'];?><!--">-->
<!--        <input class="insurance-before" name="insurance-before" type="hidden" value="--><?php //echo $order_params['insurance-before'];?><!--">-->
<!---->
<!--	    --><?php //if($order_params['insurance-before'] == '1'): //if was insurance before, send which insurance was 1,2,3 years before?>
<!--            <input class="insurance-1-year" name="insurance-1-year" type="hidden" value="--><?php //echo $order_params['insurance-1-year'];?><!--">-->
<!--            <input class="insurance-2-year" name="insurance-2-year" type="hidden" value="--><?php //echo $order_params['insurance-2-year'];?><!--">-->
<!--            <input class="insurance-3-year" name="insurance-3-year" type="hidden" value="--><?php //echo $order_params['insurance-3-year'];?><!--">-->
<!--	    --><?php //endif; ?>
<!--        <input class="law-suites-3-year" name="law-suites-3-year" type="hidden" value="--><?php //echo $order_params['law-suites-3-year'];?><!--">-->
<!--	    --><?php //if($order_params['law-suites-3-year'] == '1'):?>
<!--            <input class="law-suite-what-year" name="law-suite-what-year" type="hidden" value="--><?php //echo $order_params['law-suite-what-year'];?><!--">-->
<!--            <input class="body-claims" name="body-claims" type="hidden" value="--><?php //echo $order_params['body-claims'];?><!--">-->
<!--	    --><?php //endif; ?>
<!---->
<!--        <input class="criminal-record" name="criminal-record" type="hidden" value="--><?php //echo $order_params['criminal-record'];?><!--">-->
<!--        <input class="license-suspensions" name="license-suspensions" type="hidden" value="--><?php //echo $order_params['license-suspensions'];?><!--">-->
<!--        <input class="city" name="city" type="hidden" value="--><?php //echo $order_params['city'];?><!--">-->

        <div class="row bg-3 py-2">

            <div class="col-lg-2 d-flex d-lg-block justify-content-center">

                <span class="text-6 color-white">דברו איתנו</span>

            </div>

            <div class="col-lg-7 mb-3 mb-lg-0">

                <!-- ROW -->
                <div class="row">

                    <div class="col-lg-6">

                        <div class="s-input-wrapper d-inline-block w-100">

                            <label for="contact-compare-name-2-<?php echo $cube_index; ?>"
                                   class="hidden-lg-up text-6 color-white medium">
								<?php _e( 'Full name', 'sogoc' ); ?>
                            </label>
                            <input type="text" id="contact-compare-name-2-<?php echo $cube_index; ?>"
                                   name="contact-compare-name-2-1"
                                   class="w-100 ins_send_name"
                                   placeholder="<?php _e( 'Full name', 'sogoc' ); ?>"/>

                        </div>

                    </div>

                    <div class="col-lg-6">

                        <div class="s-input-wrapper d-inline-block w-100">

                            <label for="contact-compare-phone-<?php echo $cube_index; ?>"
                                   class="hidden-lg-up text-6 color-white medium">
								<?php _e( 'Phone', 'sogoc' ); ?>
                            </label>
                            <input type="tel" id="contact-compare-phone-<?php echo $cube_index; ?>"
                                   name="contact-compare-phone-1"
                                   class="w-100 ins_send_phone"
                                   placeholder="<?php _e( 'Phone', 'sogoc' ); ?>"/>

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-lg-3 text-left">

                <button type="submit"
                        class="contact-us-compare-send-form s-button s-button-2 bg-5 border-color-5 w-100">
					<?php _e( 'Send', 'sogoc' ); ?>
                </button>

            </div>

        </div>

    </form>

</div>