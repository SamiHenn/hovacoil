<?php
/**
 * Created by PhpStorm.
 * User: oren
 * Date: 3/26/2018
 * Time: 4:08 PM
 */

class ozar_health {

	/**
	 * @var string
	 */
	private $cookies = '';


	private $gender = array(
		83300001 => 'זכר',
		83300002 => 'נקבה',
	);
	//סוג הריבית במסלול *
	private $SelectedInsuranceTypes = array(
		83000001 => 'ניתוחים',
		83000002 => 'השתלות',
		83000004 => 'תרופות',
	);

	/**
	 * Used in ajax to build the ui
	 *
	 * @return array
	 */
	public function get_params() {
		return array(
			'SelectedInsuranceTypes' => $this->SelectedInsuranceTypes,
			'Gender'                 => $this->gender,
			'description'            => get_field( '_sogo_health_description', 'options' ),
			'thx'                    => get_field( '_sogo_health_thx', 'options' ),
		);
	}


	/**
	 * ozar_hova constructor.
	 *
	 * @param $params
	 */
	public function __construct() {


	}

	public function calc() {

		$this->get_cookie();
	}

	/**
	 *  generate cookie from the briut.cma.gov.il
	 *
	 */
	function get_cookie() {

		$api_url = 'https://briut.cma.gov.il/Parameters';

		$curl = curl_init( $api_url );
		curl_setopt( $curl, CURLOPT_HEADER, 1 );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 ); //timeout in seconds
		curl_setopt( $curl, CURLOPT_AUTOREFERER, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
		curl_setopt( $curl, CURLOPT_VERBOSE, 1 );
		curl_setopt( $curl, CURLOPT_COOKIE, "AspxAutoDetectCookieSupport:1" );

		$result = curl_exec( $curl );
		preg_match_all( '/^Set-Cookie:\s*([^;]*)/mi', $result, $matches );
//		$this->cookies = "AspxAutoDetectCookieSupport:1;";
		foreach ( $matches[1] as $item ) {
			$this->cookies .= $item . "; ";

		}


		return '';

	}

	/**
	 * @param $params
	 */
	public function connect( $params ) {
		$api_url = 'https://briut.cma.gov.il/Parameters/ComparePrices';


		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_URL, $api_url );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_COOKIE, $this->cookies );
		curl_setopt( $curl, CURLOPT_AUTOREFERER, true );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
		curl_setopt( $curl, CURLOPT_VERBOSE, 1 );
		curl_setopt( $curl, CURLOPT_POST, 1 );

		curl_setopt( $curl, CURLOPT_POSTFIELDS, json_encode( $params ) );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json'
		) );
		//execute post
		$result = curl_exec( $curl );
		//close connection
		curl_close( $curl );


		$companies = get_field( '_sogo_health_companies', 'options' );

		$names = array_column( $companies, 'name' );

		$discount = 'discount_1';
		$results  = json_decode( $result, true );
		$arr      = array();

		foreach ( $results['InsuranceCompanies'] as $row ) {
			$key = array_search( $row['MainCompanyName'], $names );
			if ( $key !== false ) {
				$arr[] = array(
					'company'                   => $companies[ $key ]['title'],
					'sub_title'                 => $companies[ $key ]['sub_title'],
					'Price'                     => ceil( $row['Price'] * ( ( 100 - $companies[ $key ][ $discount ] ) / 100 ) ),
					'Gender'                    => $this->gender[ $params['Gender'] ],
					'BirthDate'                 => date( "d-m-Y", strtotime( $params['Age'] ) ),
					'SurgeriesBullets'          => $row['SurgeriesBullets'],
					'ImplantsBullets'           => $row['ImplantsBullets'],
					'MedicationsBullets'        => $row['MedicationsBullets'],
					'SurgeriesMonthlyPremium'   => $row['SurgeriesMonthlyPremium'],
					'ImplantsMonthlyPremium'    => $row['ImplantsMonthlyPremium'],
					'MedicationsMonthlyPremium' => $row['MedicationsMonthlyPremium'],
				);
			}
		}

		//var_dump($arr);

		return $arr;


	}
}






