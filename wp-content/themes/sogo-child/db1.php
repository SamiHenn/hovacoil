<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 3/21/2018
 * Time: 10:58 AM
 */
header( "Access-Control-Allow-Origin: *" );
require_once( '../../../wp-load.php' );


$table = $wpdb->prefix . 'car_models';

/*$html = '<?xml encoding="UTF-8"><HTML><BODY><table>' . stripcslashes( $_POST['table']) .'</table></BODY></HTML>';
echo $html;
$doc    = new DOMDocument();
$doc->loadHTML( $html );
$doc->preserveWhiteSpace = false;*/

$snapir_data = json_decode( stripcslashes( $_POST['table'] ) );
$done = false;
foreach ( $snapir_data as $row ) {
	try {
		if ( isset( $row[0] ) ) {
			$no1 = str_pad( $row[1], 4, 0, STR_PAD_LEFT );
			$no2 = str_pad( $row[2], 5, 0, STR_PAD_LEFT );

			echo "$no1-$no2";

			global $wpdb;
			$table_snapir = $wpdb->prefix . 'snapir';

			$snapir_data_insert = array(
				'code_levi'           => $_POST['code'],
				'car_type'            => $row[6],
				'car_year'            => $row[5],
				'engine_capacity'     => $row[4],
				'car_model'           => $row[3],
				'license_code'        => $row[2],
				'manufacturer_number' => $row[1],
				'manufacturer'        => $row[0]
			);

			$wpdb->insert( $table_snapir, $snapir_data_insert );

			if(!$done){
				$table_car = $wpdb->prefix . 'car_models';
				$wpdb->update(
					$table_car,
					array(
						'license_code' => "$no1-$no2",    // string
					),
					array( 'code_levi' => $_POST['code'], 'year' => $_POST['year'] )

				);
				$done= true;
			}
		}


	} catch ( Exception $e ) {
		echo 'Caught exception: ', $e->getMessage(), "\n";
	}
}

die();