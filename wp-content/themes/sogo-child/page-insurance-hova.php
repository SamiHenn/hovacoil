<?php
// Template name: Hova

/*
 * checking if session $_SESSION['insurance_results'] for fix in_order ID in url query parameter
 * if yes, overriding wrong in_order ID and reload the page
 */
header( 'Cache-Control: private, no-store, max-age=0, no-cache, must-revalidate, post-check=0, pre-check=0' );
header( 'Pragma: no-cache' );
header( 'Expires: Fri, 01 Jan 1990 00:00:00 GMT' );
session_start();



$insurance_type = 'HOVA';
$left_sidebar = "left_sidebar";
$bottom_sidebar = "bottom_sidebar";
the_post();
$content   = get_the_content();
$insuranseId = 1;


get_header();


include 'page-insurance-compare-1.php';
