<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 21-Aug-17
 * Time: 12:31 PM
 */ ?>

	<?php
	wp_nonce_field( 'sogo_models', 'sogo_import_models' );

	$html = '<p class="description">';
	$html .= 'Upload your XLS here.';
	$html .= '</p>';
	$html .= '<input type="file" id="sogo_import_car_model" name="sogo_import_car_model" value="" size="55" />';
	$html .= '<div class="clear"></div>';
	$html .= '<input type="checkbox" id="sogo_truncate_table" name="sogo_truncate_table" />';
	$html .= '<label for="sogo_truncate_table">Override data</label>';
	$html .= '<div class="clear"></div>';
	$html .= '<input class="button button-primary" type="submit" value="Import">';

	echo $html;

	?>




