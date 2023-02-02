<style>
#samiloader {
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #f1c40f;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
  z-index: 999999999;
  position: fixed;
  top:  calc(50% - 60px);
  right:  calc(50% - 60px);
  display: none;
}
/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>

<script>
function samiloader() {
  document.getElementById("samiloader").style.display = "block";
  document.getElementById("div1").style.display = "block";
}
</script>

<div id="div1" class="text-3 color-3" style="height: 100%; position: fixed; top: 0px; right: 0px; width: 100%; z-index: 100; opacity: 0.45; display: none; background-color: #000000"> 
</div>
	<?php
	if ($_GET['insurance-type'] == 'MAKIF')
	{
		$showMakiflocation = 'd-none';
		$showZadglocation = '';
		$showHovalocation = '';
		$backPage = 'comprehensive-insurance';
	}
	if ($_GET['insurance-type'] == 'ZAD_G')
	{
		$showMakiflocation = '';
		$showZadglocation = 'd-none';
		$showHovalocation = '';
		$backPage = 'third-party-insurance';
	}
	if ($_GET['insurance-type'] == 'HOVA')
	{
		$showMakiflocation = '';
		$showZadglocation = '';
		$showHovalocation = 'd-none';
		$backPage = 'car-insurance';
	}
?>
<div id="samiloader" class="samiloader"></div>
<div class="col-lg-12 text-left px-2">
<div style="float: right" class="d-inline-block"><a title="חזור למילוי פרטים" onclick="samiloader()" href="../<?php echo $backPage ?>/calc/?ins_order=<?php echo $_SESSION['ins_orders'][$ins_order]['id'];?>" class="s-btn-2 text-6 bg-8 border-color-4 color-3 d-inline-block align-middle mx-0 px-1 "><span class="icon-arrowright-01-color3 icon-x2 d-inline-block align-middle ml-0"></span> חזור </a></div>
	
<span class="text-5 color-6 d-inline-block"><span class="text-6 row mr-1" style="margin-top: -10px">עוד אפשרויות:</span>
<span class="<?php echo $showMakiflocation;?>"><a title="קבל הצעות לביטוח מקיף וחובה בקליק" onclick="samiloader()" href="../comprehensive-insurance/calc/?recompare=1&ins_order=<?php echo $_SESSION['ins_orders'][$ins_order]['id'];?>" class="s-btn-1 bg-3 border-color-3 color-white d-inline-block align-middle mx-0 px-1 <?php echo $showMakiflocation;?>">מקיף וחובה<span class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></span>
</a></span>
<span class="<?php echo $showZadglocation;?>"><a title="קבל הצעות לביטוח צד ג וחובה בקליק" onclick="samiloader()" href="../third-party-insurance/calc/?recompare=1&ins_order=<?php echo $_SESSION['ins_orders'][$ins_order]['id'];?>" class="s-btn-1 bg-4 border-color-4 color-white d-inline-block align-middle  mx-0  px-1 <?php echo $showZadglocation;?>">צד ג וחובה<span class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></span>
</a></span>
<span class="<?php echo $showHovalocation;?>"><a title="קבל הצעות לביטוח חובה בקליק" onclick="samiloader()" href="../car-insurance/calc/?recompare=1&ins_order=<?php echo $_SESSION['ins_orders'][$ins_order]['id'];?>" class="s-btn-1 bg-5 border-color-5 color-white d-inline-block align-middle  mx-0  px-1 <?php echo $showHovalocation;?>">חובה בלבד<span class="icon-arrowleft-01-colorwhite icon-x2 d-inline-block align-middle"></span>
</a></span>					</span>
							</div>	