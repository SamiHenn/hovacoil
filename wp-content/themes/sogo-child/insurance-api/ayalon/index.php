<?php

/**
 * Created by PhpStorm.
 * User: danielgontar
 * Date: 10/31/17
 * Time: 4:45 PM
 */
ini_set( 'display_errors', 'On' );
require_once dirname( __FILE__ ) . '/lib/ayalonws.php';

$ayalon = new Ayalonws();
$res = $ayalon->calc_price()->CarInsuranceCalculationResult;
var_dump($res);
?>

<!--<table>-->
<!---->
<!--	<tr>-->
<!--		<td><b>SuggestionId: </b></td><td>--><?php //echo $res->SuggestionId; ?><!--</td>-->
<!--	</tr>-->
<!---->
<!--	<tr>-->
<!--		<td><b>Result: </b></td><td>--><?php //echo $res->MsgObj->Result; ?><!--</td>-->
<!--	</tr>-->
<!---->
<!--	<tr>-->
<!--		<td><b>פרמיית חובה: </b></td><td>--><?php //echo $res->PremiumDetails->CompulsoryPremium; ?><!--</td>-->
<!--	</tr>-->
<!---->
<!--	<tr>-->
<!--		<td><b>השתתפות עצמית מוסך הסדר: </b></td><td>--><?php //echo $res->PremiumDetails->DeductibleSpe; ?><!--</td>-->
<!--	</tr>-->
<!---->
<!--	<tr>-->
<!--		<td><b>השתתפות עצמית: </b></td><td>--><?php //echo $res->PremiumDetails->DeductibleReq; ?><!--</td>-->
<!--	</tr>-->
<!---->
<!--	<tr>-->
<!--		<td><b>פרמיית מקיף: </b></td><td>--><?php //echo $res->PremiumDetails->BrutoPremium; ?><!--</td>-->
<!--	</tr>-->
<!---->
<!--	<tr>-->
<!--		<td><b>מיגון נדרש תיאור: </b></td><td>--><?php //echo $res->PremiumDetails->ReqProtectionDesc; ?><!--</td>-->
<!--	</tr>-->
<!---->
<!--</table>-->

<!--<div>-->
<!---->
<!--    --><?php //var_dump($res); ?>
<!---->
<!--</div>-->
