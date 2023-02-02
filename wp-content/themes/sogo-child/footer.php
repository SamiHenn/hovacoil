</div>
<!-- /.site -->
<?php
// Get any existing copy of our transient data
//if ( false === ( $footer = get_transient( 'special_query_results' ) ) ) {
//    ob_start();
//
//    $footer= ob_get_clean();
//    set_transient( 'footer', $footer, 12 * HOUR_IN_SECONDS );
//}
//
//echo $footer;
include 'templates/footer-2/footer-2.php';
?>


<!-- BACK TO TOP-->
<div id="scrollToTop" class="back-to-top hide hidden-sm-down">
<!--    <img src="--><?php //echo ROOT_PATH . '/images/top.png'; ?><!--" alt="back-to-top-button">-->

    <div class="arrow-icon"></div>
</div>


<?php wp_footer(); ?>
</body>
</html>
