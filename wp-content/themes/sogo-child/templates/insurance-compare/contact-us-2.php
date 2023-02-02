<!-- CONTACT US FORMS -->

<div class="contact-us-by-phone d-none">

    <form action="" METHOD="post" class="contact-us-compare-form-phone-1 two" id="contact-us-compare-form-phone-<?php echo $cube_index; ?>">
        <input class="ins_order" name="ins_order" type="hidden" value="<?php echo isset($_GET['ins_order']) ? $_GET['ins_order'] : 'false';?>">
        <input class="ins_link" name="ins_link" type="hidden" value="<?php echo rtrim($_POST['ins_link'], '?');?>">
        <input class="subjectForLead" name="subjectForLead" type="hidden" value="<?php if ( isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'MAKIF' || $_GET['insurance-type'] == 'ZAD_G' ) ): ?>
<?php if ( $_GET['insurance-type'] == 'MAKIF' ): ?>
ביטוח מקיף וחובה
<?php else: ?>
ביטוח צד ג וחובה
<?php endif; ?>
<?php else: ?>
ביטוח חובה
<?php endif; ?> - <?php echo $insurance_cube['company'];  ?>">

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