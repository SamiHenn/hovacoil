<?php
// Template name: ZAD G & Hova

/*
 * checking if session $_SESSION['insurance_results'] for fix in_order ID in url query parameter
 * if yes, overriding wrong in_order ID and reload the page
 */
header( 'Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0' );
header( 'Pragma: no-cache' );
header( 'Expires: Fri, 01 Jan 1990 00:00:00 GMT' );
session_start();
//if (isset($_SESSION['insurance_results']) && !empty($_SESSION['insurance_results'])) {
//
//	$url = parse_url($_SERVER['REQUEST_URI']);
//	unset($_SESSION['insurance_results']);
//	wp_redirect(site_url('/') . $url['path'] .'?ins_order=' . $_COOKIE['ins_order']);
//	exit();
//}

$insurance_type = 'ZAD_G';
$left_sidebar = "left_sidebar_zad3";
$bottom_sidebar = "bottom_sidebar_zad3";
the_post();
$content = get_the_content();
$insuranseId = 3;

get_header();
include 'page-insurance-compare-1.php';