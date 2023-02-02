<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 3/21/2018
 * Time: 10:58 AM
 */
header("Access-Control-Allow-Origin: *");
require_once(  '../../../wp-load.php' );

global $wpdb;

$table = $wpdb->prefix . 'car_models';
$order = isset($_GET['order'])? ' order by code_levi desc ': ' order by code_levi asc ';
$rows = $wpdb->get_results("select code_levi, year from $table  where  license_code='' $order limit 1", ARRAY_A);

if($rows){
	wp_send_json($rows);
}

die();