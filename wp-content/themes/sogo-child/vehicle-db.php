<?php
/**
 * Get all distinct manufacturers
 * @return array|bool|null|object
 */
function sogo_get_manufacturers() {
	global $wpdb;

	$query = "SELECT DISTINCT manufacturer FROM wp_car_models";

	$manufactures = $wpdb->get_results( $query, ARRAY_N );

	return ! empty( $manufactures ) ? $manufactures : false;
}



function sogo_get_manufacturer_years_func() {

	$data = [];
	$data['server'] = $_SERVER;

	try {

		if ( isset( $_POST['vehicle-manufacturer'] ) ) {
			global $wpdb;

			$manufacturer = trim(strip_tags($_POST['vehicle-manufacturer']));

			$data['post'] = $_POST;
			//mail('victor@sogo.co.il,oren@sogo.co.il', 'bug report from stage hova sogo_get_manufacturer_years_func before execute query', var_export($data, true));
			$query = "SELECT DISTINCT year FROM wp_car_models WHERE `manufacturer` = '{$manufacturer}' ORDER BY `year` DESC";

			$data['query'] = $query;
			//mail('victor@sogo.co.il,oren@sogo.co.il', 'bug report from stage hova sogo_get_manufacturer_years_func query', var_export($data, true));

			$year = $wpdb->get_results( $query, ARRAY_N );
			$data['result'] = $year;
			//mail('victor@sogo.co.il,oren@sogo.co.il', 'bug report from stage hova sogo_get_manufacturer_years_func results', var_export($data, true));

			return $year   ;


		} else {
			$data['post'] = $_POST;
			mail('victor@sogo.co.il,oren@sogo.co.il', 'bug report from stage hova sogo_get_manufacturer_years_func no post params', var_export($data, true));

		}
	}  catch (Exception $e) {
		$data['error'] = $e->getMessage();
		mail('victor@sogo.co.il,oren@sogo.co.il', 'bug report from stage hova sogo_get_manufacturer_years_func error message', var_export($data, true));

	}
}

/**
 * Get all manufacturer years
 */
function sogo_get_manufacturer_years() {

	if ( isset( $_POST['vehicle-manufacturer'] ) ) {
		$year = sogo_get_manufacturer_years_func();

		wp_send_json( $year );

		die();
	}

}

add_action( 'wp_ajax_sogo_get_manufacturer_years', 'sogo_get_manufacturer_years' );
add_action( 'wp_ajax_nopriv_sogo_get_manufacturer_years', 'sogo_get_manufacturer_years' );

/**
 * Get all manufacturer years filled
 */
function sogo_get_manufacturer_years_filled($manufacturer) {
	global $wpdb;

	$query = "SELECT DISTINCT year FROM wp_car_models WHERE manufacturer = '{$manufacturer}' ORDER BY year DESC";

	$year = $wpdb->get_results( $query, ARRAY_N );

	return ! empty( $year ) ? $year : false;
}


/**
 * Get models
 */
function sogo_get_models() {
	$data = [];
	$data[' error'] = '';
	$data['server'] = $_SERVER;


	if ( isset( $_POST['vehicle-manufacturer'] ) && isset( $_POST['vehicle-year'] ) ) {

		try {
		global $wpdb;

		$manufacturer = trim(strip_tags($_POST['vehicle-manufacturer']));
		$vehicleYear = trim(strip_tags($_POST['vehicle-year']));

		$data['postParams'] = $_POST;


		$query = "SELECT DISTINCT model FROM wp_car_models WHERE `manufacturer` = '{$manufacturer}' AND `year` = '{$vehicleYear}' ORDER BY `year`";
//var_dump($query);die;
		$data['query']  = $query;

		//mail('victor@sogo.co.il,oren@sogo.co.il', 'bug report from stage hova Get Sub Models before execute query', var_export($data, true));

		$model = $wpdb->get_results( $query, ARRAY_N );

		//mail('victor@sogo.co.il,oren@sogo.co.il', 'bug report from stage hova Get Sub Models with query results', var_export($model, true));
		wp_send_json( $model );

		} catch (Exception $e) {
			$data['error'] = $e->getMessage();
			mail('victor@sogo.co.il,oren@sogo.co.il', 'bug report from stage hova Get Sub Models with error', var_export($data, true));

		}
		die();
	} else {
		$data['post'] = $_POST;
		mail('victor@sogo.co.il,oren@sogo.co.il', 'bug report from stage hova Get Sub Models with error in post parameters', var_export($data, true));
	}
}

add_action( 'wp_ajax_sogo_get_models', 'sogo_get_models' );
add_action( 'wp_ajax_nopriv_sogo_get_models', 'sogo_get_models' );

/**
 * Get models fileed
 */
function sogo_get_models_filled($manufacturer, $vehicle_year) {


		global $wpdb;

		$query = "SELECT DISTINCT model FROM wp_car_models WHERE manufacturer = '{$manufacturer}' AND year = '{$vehicle_year}' ORDER BY year";

		$model = $wpdb->get_results( $query, ARRAY_N );

		return ! empty( $model ) ? $model : false;
}

/**
 * Get sub models
 */
function sogo_get_sub_models() {

	if ( isset( $_POST['vehicle-manufacturer'] ) && isset( $_POST['vehicle-year'] ) && isset( $_POST['brand'] ) ) {
		global $wpdb;

		$query = "SELECT DISTINCT sub_model FROM wp_car_models WHERE manufacturer = '{$_POST['vehicle-manufacturer']}' AND year = '{$_POST['vehicle-year']}' AND model = '{$_POST['brand']}' ORDER BY model";
		$sub_model = $wpdb->get_results( $query, ARRAY_N );
		wp_send_json( $sub_model );

		die();
	}
}

add_action( 'wp_ajax_sogo_get_sub_models', 'sogo_get_sub_models' );
add_action( 'wp_ajax_nopriv_sogo_get_sub_models', 'sogo_get_sub_models' );


function sogo_get_safety_systems(){
	if ( isset( $_POST['vehicle-manufacturer'] ) && isset( $_POST['vehicle-year'] ) && isset( $_POST['brand'] ) && isset( $_POST['sub_brand'] )) {
		global $wpdb;

		$query = "SELECT id, code_levi, engine_capacity, fcw, ldw, esp FROM wp_car_models WHERE manufacturer = '{$_POST['vehicle-manufacturer']}' AND year = '{$_POST['vehicle-year']}' AND model = '{$_POST['brand']}' AND sub_model = '{$_POST['sub_brand']}'";
		$safety_systems = $wpdb->get_results( $query );


		wp_send_json( array('status'=>'1', 'code_levi'=>$safety_systems[0]->code_levi  ,'engine_capacity'=>$safety_systems[0]->engine_capacity, 'fcw'=>$safety_systems[0]->fcw, 'ldw'=>$safety_systems[0]->ldw, 'esp'=>is_null($safety_systems[0]->esp) ? 'null' : $safety_systems[0]->esp) );
		die();
	}
	else{
		wp_send_json(array('status'=> '0'));
	}
}

add_action( 'wp_ajax_sogo_get_safety_systems', 'sogo_get_safety_systems' );
add_action( 'wp_ajax_nopriv_sogo_get_safety_systems', 'sogo_get_safety_systems' );

/**
 * Get sub models
 */
function sogo_get_sub_models_filled($manufacturer, $vehicle_year, $brand) {
	global $wpdb;

	$query = "SELECT DISTINCT sub_model FROM wp_car_models WHERE manufacturer = '{$manufacturer}' AND year = '{$vehicle_year}' AND model = '{$brand}' ORDER BY model";

	$sub_model = $wpdb->get_results( $query, ARRAY_N );
	return ! empty( $sub_model ) ? $sub_model : false;
}


/**
 * Get levi code by brand, sub-brand, manufacturer
 */
function sogo_get_levi_code(array $args = []) {

    if(empty($_SESSION['ins_orders'])) {

        $vehicle_manufacturer = isset($_POST['vehicle-manufacturer']) ? $_POST['vehicle-manufacturer'] : $args['vehicle-manufacturer'];
        $vehicle_brand = isset($_POST['vehicle-brand']) ? $_POST['vehicle-brand'] : $args['vehicle-brand'];
        $vehicle_sub_brand = isset($_POST['vehicle-sub-brand']) ? $_POST['vehicle-sub-brand'] : $args['vehicle-sub-brand'];

        global $wpdb;

        $query = "SELECT code_levi FROM wp_car_models WHERE manufacturer = '{$vehicle_manufacturer}' AND model = '{$vehicle_brand}' AND sub_model = '{$vehicle_sub_brand}' GROUP BY code_levi";
        $levi_code = $wpdb->get_var($query);

    }else{

        $ins_order = array_key_first( $_SESSION['ins_orders'] );
        $order_params = get_ins_order( $_GET['ins_order']);//get_option( 'insurance-order_' . $ins_order );
        $levi_code = $order_params['order_details']['levi-code'];

    }

		return $levi_code;

}

/**
 * Get data for mandatory insurance
 * @return array|null|object
 */
function sogo_get_data_for_mandatory_insurance(){
	if ( isset( $_POST['vehicle-manufacturer'] ) && isset( $_POST['vehicle-sub-brand'] ) && isset( $_POST['vehicle-brand'] ) ) {
		global $wpdb;

		$query = "SELECT engine_capacity, abs, esp, fcw, ldw, air_bags FROM wp_car_models WHERE manufacturer = '{$_POST['vehicle-manufacturer']}' AND model = '{$_POST['vehicle-brand']}' AND sub_model = '{$_POST['vehicle-sub-brand']}' GROUP BY code_levi";

		$mandatory_insurance_data = $wpdb->get_results( $query, ARRAY_A );

		return $mandatory_insurance_data;
	}
}

//add_action( 'wp_ajax_sogo_get_levi_code', 'sogo_get_levi_code' );
//add_action( 'wp_ajax_nopriv_sogo_get_levi_code', 'sogo_get_levi_code' );

