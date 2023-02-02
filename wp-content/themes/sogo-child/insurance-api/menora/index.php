<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/12/2017
 * Time: 10:35 AM
 */
//$d = date("Ymd");

//$d = substr($d, 1); echo $d;die();
require_once dirname( __FILE__ ) . '/lib/menoraws.php';

$manora = new menoraws(array());




$res = $manora->calc_price(array());

echo '<pre style="direction: ltr;">';
var_dump($res);
echo '</pre>';

//$date = date( 'd/m/Y' );

//echo $date;