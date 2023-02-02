<!-- CONTACT US FORMS -->
<?php
$order_data = get_ins_order( $_GET['ins_order']);//get_option('insurance-order_' . $_GET['ins_order']);


$ins_link_arr = explode('=', $_POST['ins_link']);
$ins_link     = $ins_link_arr[0];
$order_id     = end($ins_link_arr);

//$final_link = $ins_link . '=' . urlencode($order_id);
$final_link = $contactUsOrderLink;


?>
<div class="contact-us-by-mail d-none">

    <form action="" METHOD="post" class="contact-us-compare-form-email-1 one" id="contact-us-compare-form-email-<?php echo $cube_index; ?>">
        <input class="ins_order" name="ins_order" type="hidden" value="<?php echo isset($_GET['ins_order']) ? $_GET['ins_order'] : 'false';?>">
        <input class="ins_link" name="ins_link" type="hidden" value="<?php echo rtrim($_POST['ins_link'], '?');?>">
        <input class="subjectForLead" name="subjectForLead" type="hidden" value="הצעה למייל - <?php if ( isset( $_GET['insurance-type'] ) && ( $_GET['insurance-type'] == 'MAKIF' || $_GET['insurance-type'] == 'ZAD_G' ) ): ?>
<?php if ( $_GET['insurance-type'] == 'MAKIF' ): ?>
ביטוח מקיף וחובה
<?php else: ?>
ביטוח צד ג וחובה
<?php endif; ?>
<?php else: ?>
ביטוח חובה
<?php endif; ?> - <?php echo $insurance_cube['company'];  ?>">


        <div class="row bg-5 py-2">

            <div class="col-lg-2 d-flex d-lg-block justify-content-center">

                <span class="text-6 color-white">קבל הצעה זו במייל</span>

            </div>

            <div class="col-lg-7 mb-3 mb-lg-0">

                <!-- ROW -->
                <div class="row">

                    <div class="col-lg-6">

                        <div class="s-input-wrapper d-inline-block w-100">

                            <label for="contact-compare-name-<?php echo $cube_index; ?>" class="hidden-lg-up text-6 color-white medium">
								<?php _e( 'Full name', 'sogoc' ); ?>
                            </label>
                            <input type="text" id="contact-compare-name-<?php echo $cube_index; ?>"
                                   name="contact-compare-name-1"
                                   class="w-100 ins_send_name"
                                   placeholder="<?php _e( 'Full name', 'sogoc' ); ?>"/>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="s-input-wrapper d-inline-block w-100">
                            <label for="contact-compare-email-<?php echo $cube_index; ?>" class="hidden-lg-up text-6 color-white medium">
	                            <?php _e( 'Email', 'sogoc' ); ?>
                            </label>
                            <input type="email" id="contact-compare-email-<?php echo $cube_index; ?>"
                                   name="contact-compare-email-1"
                                   class="w-100 ins_send_email"
                                   placeholder="<?php _e( 'Email', 'sogoc' ); ?>"/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 text-left">
                <button type="submit"
                        class="contact-us-compare-send-form s-button s-button-2 bg-3 border-color-3 w-100">
					<?php _e( 'Send', 'sogoc' ); ?>
                </button>
            </div>
        </div>
    </form>
</div>
