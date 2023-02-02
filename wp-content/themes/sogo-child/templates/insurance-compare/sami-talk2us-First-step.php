<?php	
	
	if ($insurance_type == 'HOVA') {
	$link = "www.hova.co.il/car-insurance/calc/?ins_order=";
	$link_ins_order = $_SESSION['ins_orders'][$ins_order]['id'];
	$samiSubTitle = "רק בחובה - משווים ובוחרים בביטוח חובה הטוב ביותר";
	$subjectForLead = "הצעת ביטוח חובה";
	}
	if ($insurance_type == 'ZAD_G') {
	$link = "www.hova.co.il/third-party-insurance/calc/?ins_order=";
	$link_ins_order = $_SESSION['ins_orders'][$ins_order]['id'];
	$samiSubTitle = "ביטוח צד ג' - השוואת 10 חברות ביטוח אונליין";
	$subjectForLead = "הצעת ביטוח צד ג וחובה";
	}
	if ($insurance_type == 'MAKIF') {
	$link = "www.hova.co.il/comprehensive-insurance/calc/?ins_order=";
	$link_ins_order = $_SESSION['ins_orders'][$ins_order]['id'];
	$samiSubTitle = "ביטוח מקיף - עד 12 הצעות מחיר אונליין";
	$subjectForLead = "הצעת ביטוח מקיף וחובה";
	}
	?>
<div class="text-3 color-3 text-right pr-1 text-right d-inline-block" style="width: 60%"><?php echo $samiSubTitle; ?></div>
<div style="width: auto; width: 37%" class="d-inline-block cursor-pointer text-left" >
<a onclick="samiShowForm()" class="text-5 color-black d-inline-block align-middle mb-1 col-auto px-2 text-center bg-white" style="text-decoration: none; line-height: 35px; border-radius: 35px">עוד אפשרויות ></a>
</div>