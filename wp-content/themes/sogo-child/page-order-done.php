<?php
// Template Name: Order done - thx

session_start();

if (!isset($_SESSION['ins_orders']) || is_null($_SESSION['ins_orders'])) {
    header('Location: https://' . $_SERVER['HTTP_HOST']);
    exit();
}

$tmpArr = [];
$insOrder = $_GET['ins_order'] ?? null;
$orderId  = $_GET['order_id'] ?? null;

if (!is_null($insOrder)) {
    unset($_SESSION['ins_orders'][$insOrder]);
    unset($_SESSION['tmp_ins_order']);
}

setcookie('done', 1, time() + (60 * 5), '/');//setting cookie for 5 min that not allow get back to insurance results page

$order_params = get_ins_order( $_GET['ins_order']);//get_option( 'insurance-order_' . $insOrder );
//Add order_id to translated fields of order info
$order_params['order_id'] = $orderId;


get_header();
$is_paid = false;
$content = get_the_content();//getting thank message
foreach ($order_params as $o_key => $o_param) {//replacing all shortcodes to valid values
    if($o_key === 'mandat-num-payments'){
        $is_paid = true;
    }
    if (is_array($o_param)) {
        foreach ($o_param as $key => $param) {
            $content = str_replace('@' . $key . '@', $param, $content);
        }
    } else {

        $content = str_replace('@' . $o_key . '@', $o_param, $content);
    }
}
?>


    <!-- BANNER -->
<?php include('templates/content-header-banner.php'); ?>

<?php
$x = get_option('insurance-order_paid_' . $orderId);
$is_paid = $is_paid && empty($x);
delete_option('insurance-order_paid_' . $orderId);

if($is_paid){
    require_once  get_stylesheet_directory() ."/lib/pelecard.php";
    $pelecard = new  pelecard();
    $iframe_url = $pelecard->redirect_url($orderId);
}


?>

    <div class="container-fluid bg-8">
        <div class="row justify-content-center">
            <!-- TEXT -->
            <div class="col-lg-6">
                <!-- CONTENT -->
                <?php if($is_paid): ?>
                    <div class="color-4 text-2 pb-2 mt-2">תשלום מאובטח</div>
                    <div class="color-3 text-4">החיוב יבוצע רק לאחר אישור הפוליסה</div>
				    <div class="my-2 color-black text-5">כרטיס מסוג דיירקט / דביט / נטען לא יתקבל בחלק מחברות הביטוח לכן כדאי לשלם בכרטיס אשראי רגיל.</div>
                    <iframe style="width: 100%; margin:0 auto; min-height: 700px;border:0; border-radius: 10px" src="<?php echo($iframe_url); ?>"></iframe>

                    <script>
                        window.onbeforeunload = confirmExit;
                        function confirmExit() {
                            window.onbeforeunload = null;
                            return "לקוח יקר, לידיעתך, לאחר עזיבת דף זה לא ניתן לחזור אליו מאוחר יותר והתשלום יתבצע טלפונית.";
                        }
                    </script>
                <?php else:?>

                    <h1 class="text-1 color-4"><?php the_title(); ?></h1>
                    <div class="entry-content">
                        <?php // the_content(); ?>
                        <?php echo apply_filters('the_content',$content); ?>
                    </div>


                <?php endif; ?>
            </div>
        </div>



        <div class="row justify-content-between align-items-end border-bottom border-width-x2 border-color-6">
            <div class="bottom-right-image p-relative">
                <?php echo wp_get_attachment_image(get_field('_sogo_bottom_right_image', 'option'), 'full'); ?>
            </div>

            <div class="bottom-left-image p-relative hidden-md-down">
                <?php echo wp_get_attachment_image(get_field('_sogo_bottom_left_image', 'option'), 'full'); ?>
            </div>
        </div>
    </div>

<?php get_footer() ?>
