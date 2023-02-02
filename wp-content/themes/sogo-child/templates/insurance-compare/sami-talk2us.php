<div class="col-lg-12 px-0 insurance-cube-wrapper mb-3 d-none">
<div class="insurance-cube pt-1">
    <div class="d-flex align-items-center justify-content-between mb-1">
        <div>
            <div class="d-inline-block cursor-pointer receive-offer-by-phone" id="receive-offer-by-phone-1">
                <span class="custom-circle bg-2"><i class="icon-phone-01-colorwhite icon-x2 icon-x2 d-inline-block align-middle"></i></span>
                <span class="text-45 color-3 v-align-middle regular">רכישה טלפונית</span> <span class="icon-arrowleft-01 color-3 d-inline-block align-middle text-5"></span>
            </div>
        </div>
    </div>
<div class="contact-us-by-phone animated fadeInRight d-none">
<form action="" method="post" class="contact-us-compare-form-phone-1 two" id="contact-us-compare-form-phone-1">
<input class="ins_order" name="ins_order" type="hidden" value="<?php echo $_GET['ins_order']?>">
    <?php
	if ($_GET['i_type']==1) {
	$link = "www.hova.co.il/car-insurance/calc/?ins_order=";
	$link_ins_order = $_GET['ins_order'];
	}
	if ($_GET['i_type']==3) {
	$link = "www.hova.co.il/third-party-insurance/calc/?ins_order=";
	$link_ins_order = $_GET['ins_order'];
	}
	if ($_GET['i_type']==2) {
	$link = "www.hova.co.il/comprehensive-insurance/calc/?ins_order=";
	$link_ins_order = $_GET['ins_order'];
	}
	?>
<input class="ins_link" name="ins_link" type="hidden" value="<?php echo $link; echo $link_ins_order;?>">
<input class="leadType" name="leadType" type="hidden" value="הזמנה בביצוע">
<div style="margin: 0px; border-radius: 15px" class="row bg-5 py-2">
<div class="col-lg-2 d-flex d-lg-block justify-content-center">
<span class="text-6 color-white">רכישה טלפונית</span>
</div>
<div class="col-lg-7 mb-3 mb-lg-0">
<!-- ROW -->
<div class="row">
<div class="col-lg-6">
<div class="s-input-wrapper d-inline-block w-100">
<label for="contact-compare-name-2-1" class="hidden-lg-up text-6 color-white medium">
שם מלא                            </label>
<input type="text" id="contact-compare-name-2-1" name="contact-compare-name-2-1" class="w-100 ins_send_name" placeholder="שם מלא">
</div>
</div>
<div class="col-lg-6">
<div class="s-input-wrapper d-inline-block w-100">
<label for="contact-compare-phone-1" class="hidden-lg-up text-6 color-white medium">
טלפון                            </label>
<input type="tel" id="contact-compare-phone-1" name="contact-compare-phone-1" class="w-100 ins_send_phone" placeholder="טלפון">
</div>
</div>
</div>
</div>
<div class="col-lg-3 text-left">
<button type="submit" class="contact-us-compare-send-form s-button s-button-2 bg-3 border-color-3 w-100">
המשך                </button>
</div>
</div>
</form>
</div>
</div>
</div>
