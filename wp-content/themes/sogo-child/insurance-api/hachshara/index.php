<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/12/2017
 * Time: 9:18 AM
 */

require_once dirname( __FILE__ ) . '/lib/hachsharaws.php';

$hachshara = new hachsharaws();

$res = $hachshara->calc_price();

echo 'Hachshara: ';

echo '<pre style="direction: ltr;">';
var_dump($res->GetCarOfferResult);
echo '</pre>';

//var_dump($res);
