<?php
/*ini_set('display_errors', 1);
error_reporting(E_ALL);
echo '<pre style="direction: ltr;">';
var_dump(dirname( __FILE__ ));
echo '</pre>';*/
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/12/2017
 * Time: 4:24 PM
 */
//$client = new SoapClient('https://qa.shirbit.co.il/ShirbitQuotes/CalcCarsPremium.aspx?WSDL');
//var_dump($client->());
require_once dirname( __FILE__ ) . '/lib/shirbitws.php';

$shirbit = new shirbitws();

$res = $shirbit->calc_price();

var_dump($res);
