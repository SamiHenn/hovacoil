<?php // Template Name: front page not public ?>
<?php


//echo phpinfo();
//unset cookie, that is responsible for redirect after thanks page, if trying to back to insurance results page
if (isset($_COOKIE['done'])) {
    setcookie('done', '', time() - 1000, '/');
}

/**
 *  SETUP startup setting to control insurance orders
 */

/**
 * Setup required parameters for insurance order
 */

$aff = $_GET['aff'] ?? 0; // new order from CRM opened by agent - affiliate ID
$src = $_GET['src'] ?? 0; // surfing source CRM????
$ai = $_GET['ai'] ?? 0; // update order from crm by agent ai - agent ID
$ci = $_GET['ci'] ?? 0; // update order from crm by compare insurance button
$oi = $_GET['oi'] ?? 0; // update order from crm by compare insurance button.  oi - order id
$insType = $_GET['i_type'] ?? 0; //insurance type from crm


//avoid tricks and bug, we check if isset ins_order and if isset,
// we check that the source is crm and exists agent id or affiliate id
if (isset($_GET['ins_order'])) {
    $ins_order = $_GET['ins_order'];
    //src = 1 is CRM
    $ins_order = trim(strip_tags($ins_order));

    if ((int)$src !== 0 && (int)$aff !== 0) {
//        $ins_order = trim(strip_tags($_GET['ins_order']));
    } else if ((int)$src !== 0 && (int)$ai !== 0) {
        if ($ci !== 0) {
            // if we came from the crm and would like to duplicate the order
            $new_ins_order = uniqid();
            $order_params = get_ins_order($ins_order); //get_option( 'insurance-order_' . $ins_order );

            $_SESSION['ins_orders'][$new_ins_order]['id']       = $new_ins_order;
         //   update_option( 'insurance-order_' . $new_ins_order ,$order_params);
            save_ins_order($new_ins_order, $order_params);
            $ins_order = $new_ins_order;


        }
    }

    if($ai === '-1'){ // if a customer come with a continue link without ai variable => clear step 3
        $customer_ins_order = uniqid();

        $order_params = get_ins_order($ins_order); //get_option( 'insurance-order_' . $ins_order );

//        var_dump($order_params);die;
        $order_params =  sogo_clean_step_3($order_params);
        save_ins_order($customer_ins_order, $order_params);
      //  update_option( 'insurance-order_' . $customer_ins_order ,$order_params);
        $ins_order = $customer_ins_order;
    }

} else {
    //
    $ins_order = uniqid();
}




/**
 * SETUP cookie to control sessions flow of ins orders
 */
if (!isset($_SESSION) || empty($_SESSION)) {
    session_start();
}


/**
 * Setup required sessions to control insurance order and auto fill fields
 */

$_SESSION['new-ins_orders'] = isset($new_ins_order) ? $new_ins_order: false;

$_SESSION['tmp_ins_order'] = $ins_order;
$_SESSION['ins_orders'][$ins_order]['id'] = $ins_order;

//insurance type can change on insurance-compare-1 - line 21
$_SESSION['ins_orders'][$ins_order]['ins_type'] = $insType;//saving previous insurance type
$_SESSION['aff'] = $aff;
$_SESSION['ai'] = $ai;//agent id if order was updated from crm
$_SESSION['ci'] = $ci;
$_SESSION['oi'] = $oi;
$_SESSION['src'] = $src;



/**
 * end of condition to avoid fraud with insurances
 */

?>


<?php get_header(); ?>

<?php //include 'page-order-done.php'; ?>
<?php //get_footer();die; ?>

<?php include 'links-for-not-public.php'; ?>

<?php get_footer(); ?>


