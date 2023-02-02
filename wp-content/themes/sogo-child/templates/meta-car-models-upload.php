<?php
/**
 * Created by PhpStorm.
 * User: Alex
 * Date: 08-Mar-18
 * Time: 10:10 AM
 */

//show notice message if bulk process running
if(isset($_REQUEST['import']) && $_REQUEST['import'] == 'failure'){
	$class = 'notice notice-error';
	$message = 'There was an error to import car models';

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}
elseif (isset($_REQUEST['import']) && $_REQUEST['import'] == 'success'){
	$class = 'notice notice-success';
	$message = 'Success';

	printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) );
}

?>
    <div class="clear"></div>
    <div class="wrap">
        <div class="clear"></div>
        <div class="main_holder" style="display: block;">
            <div style="width: 80%;">
                <div class="postbox">
                    <h2 class="ui-sortable-handle" style="padding: 8px 12px; cursor: none; margin: 0;"><span>Import Car Models</span>
                    </h2>
                    <div class="inside">
                        <form method="post" enctype="multipart/form-data">
                            <?php include "meta-upload-models.php"; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>