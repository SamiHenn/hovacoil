<?php
/**
 * Created by PhpStorm.
 * User: danielgontar
 * Date: 10/31/17
 * Time: 4:53 PM
 */

ini_set( 'display_errors', 'On' );


class Shomera {

	private $api_url;
	private $response;
	private $prices_array = array();
	private $company;

	public function __construct( $company ) {
		//$this->api_url = "http://80.179.228.83/Wwa/MainService.asmx"; // live
		$this->api_url = "http://80.179.228.87/Wwa/MainService.asmx"; // live
//		$this->api_url = "http://192.168.75.7/Wwa/MainService.asmx"; // live
//		$this->api_url = "http://80.179.228.83:80/Wwa/Mutzar1Service.asmx"; // live
//		var_dump(file_get_contents($this->api_url));
		$this->company = $company;
	}

	function get_api_response( $xml ) {
		$curl = curl_init();

		curl_setopt_array( $curl, array(
			CURLOPT_URL            => $this->api_url,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING       => "",
			CURLOPT_MAXREDIRS      => 10,
			CURLOPT_TIMEOUT        => 2,
			CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST  => "POST",

			CURLOPT_POSTFIELDS => "<soap:Envelope xmlns:soap=\"http://www.w3.org/2003/05/soap-envelope\" xmlns:tem=\"http://tempuri.org/\">
									   <soap:Header/>
									   <soap:Body>
									      <tem:ProcessXml>
									         <tem:sGuid>09CA1271-6745-4468-8E3A-876E51ED1114</tem:sGuid>
									         <tem:sXmlQ><![CDATA[$xml]]></tem:sXmlQ>
									      </tem:ProcessXml>
									   </soap:Body>
									</soap:Envelope>",
			CURLOPT_HTTPHEADER => array(
				"Content-Type: text/xml",
				"SOAPAction: http://tempuri.org/ProcessXml",
				"cache-control: no-cache,no-cache"
			),
		) );
		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'SHOMERA ' );
			var_dump( $xml );
			echo '</pre>';
		}

//		var_dump( $xml );
		$response = curl_exec( $curl );
		$err      = curl_error( $curl );

		curl_close( $curl );


		if ( $err ) {
            if ( isset( $_GET['dev'] ) ) {
                var_dump($err);
            }
			return false;
		} else {
			$string  = html_entity_decode( $response );
			$pattern = "#<\s*?ProcessXmlResult\b[^>]*>(.*?)</ProcessXmlResult\b[^>]*>#s";
			preg_match( $pattern, $string, $matches );
			$xml = $matches[1];

			$xmldata      = simplexml_load_string( $xml );
			$json_string  = json_encode( $xmldata );
			$result_array = json_decode( $json_string, true );
			if ( isset( $_GET['dev'] ) ) {
				echo '<pre style="direction: ltr;">';
				var_dump( $result_array );
				echo '</pre>';
				var_dump( 'shomera END' );
				echo '</pre>++++++++++++++';
			}

			if ( $result_array['REPLY_CODE']['APPL_ERR_CODE'] === "0000" ) {
				return $result_array['RESPONSE']['F'];
			}

			return false;


		}
	}


	public function calc_price_csharp( $insurance_params ) {
		// SHOMERA C NO YOUNG OR NEW DRIVERS
		if((int)$insurance_params['youngest-driver'] < 24){
			return false;
		}
		if((int)$insurance_params['lowest-seniority'] < 1){
			return false;
		}
		if((int)$insurance_params['law-suites-3-year'] > 1){
			return false;
		}
		// SHOMERA C IF HAS 3 YEARS HISTORY ONE YEAR MUST TO BE MAKIF AND IF TWO YEARSE THEY HAVETO BE MAKIF
		if (((int)$insurance_params['insurance-1-year'] !== 1) && ((int)$insurance_params['insurance-2-year'] !== 1) && ((int)$insurance_params['insurance-3-year'] !== 1)) {
			return false;
	    }
		if (((int)$insurance_params['insurance-3-year'] === 3) && (((int)$insurance_params['insurance-1-year'] !== 1) || ((int)$insurance_params['insurance-2-year'] !== 1))) {
			return false;
	    }
		// SHOMERA C NO SHLILOT
		if((int)$insurance_params['license-suspensions'] !== 0){
			return false;
		}
		$xml      = $this->get_xml( $insurance_params, 730 );
//		$xml_hova = $this->get_xml( $insurance_params, 739 );

//		$hova  = $this->get_api_response( $xml_hova );

		$mekif = $this->get_api_response( $xml );
		if ( !  $mekif ) {
			// error in api return empty array
			return array();
		}
//		$values_hova = $this->extract( $hova, array( 'DQ-NETPREM', 'KODMIGUN' ) );
		$values      = $this->extract( $mekif, array( 'DQ-NETPREM', 'GM-KODMIGUN', 'PREMIA_HOVA' ) );

		//setup end date ************

		$start_date = $this->get_date( $insurance_params['insurance_period'], true );
		$end_date   = $this->get_date( $insurance_params['insurance-date-finish'], true );

		//Days number for calc mandatory insurance price of days left in year
		$days_left = (int) $end_date->diff( $start_date )->format( "%a" ) + 1;
		$private   = strlen( ltrim( $insurance_params['levi-code'], '0' ) ) <= 6;


		$comprehensive = $values['DQ-NETPREM'];
		$mandatory_price   = ceil($values['PREMIA_HOVA']);

		// sami try
		//$dayStartShomeraHova = get_date( $insurance_params['insurance_period']>format( 'j' ) );
		//$percentShomeraHova = 366 - $dayStartShomeraHova / 365 ;

		
		//Fix mandatory insurance price by day left in year
		$price_for_day = $mandatory_price / 365;
		$new_price     = ceil($price_for_day * $days_left);


		$this->prices_array['mandatory']     = $new_price;
		$this->prices_array['comprehensive'] = $comprehensive;
		$this->prices_array['protect']       = $values['GM-KODMIGUN'];
		$this->prices_array['protect_id']    = $values['GM-KODMIGUN'];
		$this->prices_array['id']            = $this->company['company_id'];
		$this->prices_array['company']       = $this->company['mf_company_name'];
		$this->prices_array['company_id']    = $this->company['company_id'];
		$this->prices_array['company_slug']  = 'shomera';


		return $this->prices_array;


	}


	function extract( $params, $values ) {
		//var_dump($params);
		$return = array();
		foreach ( $params as $param ) {

			$key = array_search( $param['N'], $values );

			if ( $key !== false ) {
				$return[ $values[ $key ] ] = $param['V'];
			}
		}

		return $return;


	}


	private function ins_type() {
		return isset( $_GET['insurance-type'] ) && $_GET['insurance-type'] == 'ZAD_G' ? '4' : '1';
	}

	private function get_xml( $insurance_params, $lob ) {


		$message_id = $this->GUID();
		$unique_id  = substr( $message_id, 0, 24 );

		$code_levi     = ltrim( $insurance_params['levi-code'], '0' );
		$car_year      = (int) $insurance_params['vehicle-year'];
		$drivers_count = $this->no_of_drivers( $insurance_params['drive-allowed-number'] );
//
//


		$params = [
			'HEADER' => [
				'KEY'           => [
					'LOB'         => $lob,
					'ACTIVITY'    => '613',
					'USER'        => '',
					'APPLICATION' => [
						'SYSTEM'    => '',
						'SUBSYSTEM' => '',
						'ACTION'    => '',
					],
				],
				'SESSION'       => [
					'SESSIONID_CREATOR' => 'INTERNET',
					'SESSION_TYPE'      => 'SELL PROCCESS',
					'SESSIONID'         => $unique_id,
				],
				'MSGID'         => $message_id,
				'LOG_LEVEL'     => 'L',
				'REQUEST_FLAG'  => '',
				'CHK_FLD_EXIST' => '1',
			],

			'REQUEST' => [
				[ 'N' => 'DQ-CODE', 'V' => '613' ],
				[ 'N' => 'GM-CODESHERUT', 'V' => '613' ],
				[ 'N' => 'DQ-CURRENCY', 'V' => '0' ],
				[ 'N' => 'DQ-DOCTYPE', 'V' => '1' ],
				[ 'N' => 'DQ-STARTDT', 'V' => $this->get_date( $insurance_params['insurance_period'] ) ],
				[ 'N' => 'DQ-ENDDT', 'V' => $this->get_date( $insurance_params['insurance-date-finish'] ) ],
				[ 'N' => 'DQ-ADDITIONDT', 'V' => '' ],
                [ 'N' => 'DQ-SOCHENA-NO', 'V' => '814981' ], //'952971'
				[ 'N' => 'DQ-CLASS', 'V' => $lob ],
				[ 'N' => 'DQ-CATEGORY', 'V' => '1' ],
				[ 'N' => 'DQ-RISHUI-8', 'V' => $insurance_params['license_no'] ],
				[ 'N' => 'DQ-MODELCODE', 'V' => $code_levi ],
				[ 'N' => 'DQ-MAKE', 'V' => $car_year ],
				[ 'N' => 'DQ-TRANSMIT', 'V' => '0' ],
				[ 'N' => 'DQ-SEATS', 'V' => '5' ],
				[ 'N' => 'DQ-KIS-ZMAN', 'V' => '1' ],
				//[ 'N' => 'DQ-ZIP-HOLDER', 'V' => '49500' ],
				[ 'N' => 'GM-COVERAGE-TYPE', 'V' => '5' ],
				[ 'N' => 'GM-DRIVER-TYPE', 'V' => $drivers_count ],
				//[ 'N' => 'GM-YOUNG-FM-DRIVER-EXPASION', 'V' => '' ],
				[ 'N' => 'GM-GROUND-FLAT', 'V' => '2' ],
				[ 'N' => 'GM-COMPANY-CAR', 'V' => $insurance_params['ownership'] == '2' ? '1' : '2' ],
				[ 'N' => 'GM-CLAIMS-CURRENT-YR', 'V' => $this->get_tviot( 1, $insurance_params ) ],
				[ 'N' => 'GM-CLAIMS-YEAR-AGO', 'V' => $this->get_tviot( 2, $insurance_params ) ],
				[ 'N' => 'GM-CLAIMS-TWO-YEARS-AGO', 'V' => $this->get_tviot( 3, $insurance_params ) ],
				[ 'N' => 'GM-SHABAT-DRIVING', 'V' => (int) $insurance_params['drive-on-saturday'] ],
//				[ 'N' => 'GM-HOVA-DISCOUNT', 'V' => '1' ],
				[ 'N' => 'GM-LICENSING-YEARS', 'V' => $insurance_params['lowest-seniority'] ],
				[ 'N' => 'GM-YOUNG-DRIVER-AGE', 'V' => (int) $insurance_params['youngest-driver'] ],
				[ 'N' => 'GM-YOUNG-DRIVER-GENDER', 'V' => (int) $insurance_params['gender'] ],
				[ 'N' => 'GM-PRODUCT-NUMBER', 'V' => '15' ],
				[ 'N' => 'GM-DICOUNTS', 'V' => '' ],
				[ 'N' => 'GM-RIDERS', 'V' => '6' ],
				[ 'N' => 'GM -LIABILITY', 'V' => '' ],
				[ 'N' => 'GM-MAIN-DRIVER-STATUS', 'V' => '' ],
				[ 'N' => 'TBL077', 'V' => '' ],
				[ 'N' => 'TBL025', 'V' => '' ],
				[ 'N' => 'GM-UNDERWITER-DISCOUNT', 'V' => '2' ],
				[ 'N' => 'GM-MANAGER-DISCOUNT-PERCENT', 'V' => '1000' ],
				[ 'N' => 'GM-MANAGER-DISCOUNT', 'V' => '1' ],
				

				


			],
		];


		$xmlObj = new SimpleXMLElement( '<ROOTIN/>' );
		$this->arrayToXML( $params, $xmlObj );
		$xmlRequestStr = $xmlObj->asXML();

		//$xmlRequestStr = str_replace( '<F/>', '', $xmlRequestStr );

		return $xmlRequestStr;
	}


	function arrayToXML( array $array, SimpleXMLElement &$xml ) {
		foreach ( $array as $key => $value ) {
			// Array
			if ( is_array( $value ) ) {
				$xmlChild = is_numeric( $key ) ? $xml->addChild( "F" ) : $xml->addChild( $key );
				$this->arrayToXML( $value, $xmlChild );
				continue;
			}
			// Object
			if ( is_object( $value ) ) {
				$xmlChild = $xml->addChild( get_class( $value ) );
				$this->arrayToXML( get_object_vars( $value ), $xmlChild );
				continue;
			}
			// Simple Data Element
			is_numeric( $key ) ? $xml->addChild( "F", $value ) : $xml->addChild( $key, $value );
		}
	}


	/**
	 * """ללא תביעות"" = 999
	 * ""ללא עבר ביטוחי"" = 998
	 * ""תביעה אחת"" = 1
	 * ""שתי תביעות"" = 2
	 * ""שלוש תביעות ומעלה"" = 3"
	 *
	 *
	 * 4=no claims, 9= not insured,1=1 claim,2= 2 claims, 3= 3claims
	 */

	function get_tviot( $year, $params ) {
		/**
		 * if we have in the current year insurance, we will check the suite year and last 3 years suites
		 */

		if ( $year === 3 && $this->ins_type() === 4 ) {
			return '4';
		}
		// year has insurance
		$has_insurance = $params["insurance-$year-year"];
		$suites        = (int) $params["law-suites-3-year"];
		$suite_year    = (int) $params["law-suite-what-year"];


		if ( (int) $has_insurance === 1 | (int) $has_insurance === 2 ) {
			if ( $suites === 0 || (int) $year !== $suite_year ) {
				return '4';
			} else {
				return $suites; // number of suites
			}
		} else {
			return '9'; // no insurance for this year
		}


	}

	private function get_date( $val, $obj = false ) {
		$time_zone  = new DateTimeZone( 'Asia/Jerusalem' );
		$start      = str_replace( '/', '-', $val );
		$start_date = new DateTime( $start, $time_zone );
		if ( $obj ) {
			return $start_date;
		}

		return $start_date->format( 'Ymd' );
	}

	private function get_license_date( $val ) {

		$time_zone = new DateTimeZone( 'Asia/Jerusalem' );

		$start_date = new DateTime( 'now', $time_zone );
		$r_date     = $start_date->modify( '-' . $val . ' year' );

		return $r_date->format( 'Y' );

	}

	/**
	 * "כל נהג 1
	 * נהג נקוב 2
	 * 2 נהגים נקובים 3
	 * 3 נהגים נקובים 4"
	 */
	private function no_of_drivers( $val ) {

		switch ( $val ) {
			case 1:
				$NumOfDrivers = 2;
				break;
			case 2:
				$NumOfDrivers = 3;
				break;
			case 3:
				$NumOfDrivers = 4;
				break;			
			default:
				$NumOfDrivers = 1;
				break;
		}

		return $NumOfDrivers;
	}

	function GUID() {
		if ( function_exists( 'com_create_guid' ) === true ) {
			return trim( com_create_guid(), '{}' );
		}

		return sprintf( '%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 16384, 20479 ), mt_rand( 32768, 49151 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 ), mt_rand( 0, 65535 ) );
	}

}
