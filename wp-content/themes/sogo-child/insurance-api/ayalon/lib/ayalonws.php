<?php
/**
 * Created by PhpStorm.
 * User: danielgontar
 * Date: 10/31/17
 * Time: 4:53 PM
 */

class Ayalonws {

	private $api_url;
	private $params;
	private $soap;
	private $xml_obj;
	private $response;
	private $ayalon_array;
	private $company;

	public function __construct( $company ) {


		try {
			$this->soap = new SoapClient( dirname( __FILE__ ) . '/AyalonPriceCalculation.wsdl' );
		} catch ( SoapFault $e ) {
			//echo $e->getMessage();
		}

		$this->company = $company;
	}

	public function calc_price( $insurance_params ) {
//		debug( $insurance_params );

//var_dump(is_null($insurance_params['levi-code']));
		if ( is_null( $insurance_params['levi-code'] ) ) {
			return false;
		}	
		{
		if (((int)$insurance_params['insurance-1-year'] === 3) && ((int)$insurance_params['insurance-2-year'] === 3) && ((int)$insurance_params['insurance-3-year'] === 3) || ((int)$insurance_params['insurance-before'] === 2) || ((int)$insurance_params['law-suites-3-year'] === 2))
			return false;
    }
		
//		debug( $insurance_params );

//var_dump(is_null($insurance_params['levi-code']));
		if ( is_null( $insurance_params['levi-code'] ) ) {
			return false;
		}	
		
// אם יש עבר מלא - אין צורך בענף רגיל
		if (((int)$insurance_params['insurance-1-year'] !== 3) && ((int)$insurance_params['insurance-2-year'] !== 3) && ((int)$insurance_params['insurance-before'] !== 2)){
			return false;
    }
		
// אם אחת מהשנים היא צד ג - ובנוסף אין תביעה אבל יש שנה נוספת ללא עבר ביטוחי		
		
		
// ביטול השנה השלישית כשיש צד ג באחת מהשנים
		if ((((int)$insurance_params['insurance-1-year'] === 2) || ((int)$insurance_params['insurance-2-year'] === 2) || ((int)$insurance_params['insurance-3-year'] === 2)) && ((int)$insurance_params['law-suites-3-year'] === 0)){
			$zadgPast3 = 9;
			$rezefBit = "TWO";
    }	
		//		echo '<pre style="direction: ltr;">';
//		var_dump($insurance_params);
//		echo '</pre>';
		$time_zone = new DateTimeZone( 'Asia/Jerusalem' );

		//setup start date ************
		$start                = str_replace( '/', '-', $insurance_params['insurance_period'] );
		$start_date           = new DateTime( $start, $time_zone );
		$start_date_formatted = $start_date->format( 'Y-m-d' );

		//setup end date ************
		$end                = str_replace( '/', '-', $insurance_params['insurance-date-finish'] );
		$end_date           = new DateTime( $end, $time_zone );
		$end_date_formatted = $end_date->format( 'Y-m-d' );

		//Days number for calc mandatory insurance price of days left in year
		$days_left = (int) $end_date->diff( $start_date )->format( "%a" ) + 1;

		//setup number of drivers *************
		$NumOfDrivers = '';
		switch ( $insurance_params['drive-allowed-number'] ) {
			case 1:
				$NumOfDrivers = 'ONE';
				break;
			case 2:
				$NumOfDrivers = 'ONE';
				break;
			default:
				$NumOfDrivers = 'ANY';
				break;
		}

		//setup youngest driver age *************
		$today        = new DateTime( 'now', $time_zone );
		$youngest_age = $today->modify( '-' . $insurance_params['youngest-driver'] . ' year' );


		//setup Rishayon Date *************
		$today2 = new DateTime( 'now', $time_zone );

		$r_date = $today2->modify( '-' . $insurance_params['lowest-seniority'] . ' year' );
		$r_date = $r_date->format( 'Y' ) . "-01-01T00:00:00";

//		echo '<pre style="direction: ltr;">';
//		var_dump($insurance_params);
//		echo '</pre>-------------------------------------------------------';
//		echo '-----------------------------------------------------';
//		var_dump($r_date);

		//remove all leading zeros from levi code
		$code_levi = ltrim( $insurance_params['levi-code'], '0' );

		//if code levi length is 7 its commercial vehicle type, else its private
		$vehicle_type_by_levi = strlen( $code_levi );

		$this->params = array(
			'input' => array(
				"Anaf"               => "CASCO",
				"InsuranceStartDate" => $start_date_formatted . "T00:00:00",
				"InsuranceEndDate"   => $end_date_formatted . "T00:00:00",
				"AgentId"            => "520250",
				"Password"           => "CB791924-1BB9-4012-81E2-21A7BF57076E",

				"CarDetails" => array(
					'ManufactoreId' => '0',
					'CarType'          => $vehicle_type_by_levi != 7 ? 'PRIVATE' : 'COMMERCIAL',
					"Ownership"        => $insurance_params['ownership'] == '1' ? 'PRIVATE' : 'COMMERCIAL',
//					"CarLicense"       => 0, //not mandatory
//					"EngineVolume"     => 1798, //not mandatory
					"Year"             => (int) $insurance_params['vehicle-year'],
					"GearType"         => $insurance_params['gears'] == '1' ? 'MANUAL' : 'AUTOMATIC',
					"ESP"              => (int) $insurance_params['esp'] === 1 ? "YES" : "NO",
					"FCW"              => (int) $insurance_params['keeping-distance-system'] === 1 ?  "YES" : "NO",
					"LDW"              => (int) $insurance_params['deviation-system'] === 1 ?  "YES" : "NO",
					"ModelId"          => $insurance_params['levi-code'],
					//588300
//					"ManufactoreId"    => 2,
					"InsurenceCarType" => isset( $_GET['insurance-type'] ) && $_GET['insurance-type'] == 'ZAD_G' ? "ZAD_G" : "MAKIF",

					"MainDriverGender"           => $insurance_params['gender'] == '1' ? 'MALE' : 'FEMALE',
					"NumOfDrivers"               => $NumOfDrivers,
					//setup above in the beginning of the function
					"YoungestDriverAge"          => (int) $insurance_params['youngest-driver'],
					"YoungestBirthdate"          => $youngest_age->format( 'Y-m-d' ) . "T00:00:00",
					//"YoungestDriverRishayonDate" => $r_date->format( 'Y-m-d' ) . "T00:00:00",
					"YoungestDriverRishayonDate" => $r_date,
					"OldestDriverAge"            => 80,
					"RishayonDate"               => "$r_date",
					//"2005-01-01T00:00:00",
					"Revocations"                => isset( $insurance_params['license-suspensions'] ) ? (int) $insurance_params['license-suspensions'] : 0,
					"PersonalinjuryClaims"       => isset( $insurance_params['body-claims'] ) ? (int) $insurance_params['body-claims'] : 0,
					"VetekNehiga"                => (int) $insurance_params['lowest-seniority'] >= 1 ? "NO" : "YES",

					"Grira"           => "NO",
					"Shmashot"        => "NO",
					"Halifi"          => "NO",
					"IsDriveOnShabat" => ( (int) $insurance_params['drive-on-saturday'] === 1 ?  "YES" : "NO" ),
					"Vip"             => "CAR",
					'HovaHofef'       => "YES",
					//"hanachatHatama" => 25,
					//"hanachatSochen" => 20,
					//"PREMIA_KITUM"   => 5.500,
//					"numOfClaims"     => isset( $insurance_params['law-suites-3-year'] ) ? (int)$insurance_params['law-suites-3-year'] : 0,
//					"RetzefBituhi"    => "THREE",
					'PanasimMaraot'   => "NO",
					'Earthquake'   => "NO",
					'RiotsStrikes'   => "NO",
					'ZechutNigrar'   => "NO",
					'NewOld'   => 0,
					'HanachatSochen'   => 0,
					'SapakHavilaAlifim'   => 0,
					'SheverShmashotAdHabait'   => "NO",

					"cliamsHistoryCarLast3Years" =>
						array(
							array(
								"NumOfCarClaims"   => isset( $insurance_params['law-suite-what-year'] ) && $insurance_params['law-suite-what-year'] == '1' ? 1 : 0,
								"InsuranceCompany" => 1,
								"numOfYearsBefore" => 1
							),
							array(
								"NumOfCarClaims"   => isset( $insurance_params['law-suite-what-year'] ) && $insurance_params['law-suite-what-year'] == '2' ? 1 : 0,
								"InsuranceCompany" => 1,
								"numOfYearsBefore" => 2
							),
							array(
								"NumOfCarClaims"   => isset( $insurance_params['law-suite-what-year'] ) && $insurance_params['law-suite-what-year'] == '3' ? 1 : 0,
								"InsuranceCompany" => 1,
								"numOfYearsBefore" => 3
							),

						),

				)
			)

		);


		//verify if was insurance before period
		//$insurance_params['insurance-1-year']  value = 1 - Makif, 2 - Third party , 3 - No insurance
		//$insurance_params['insurance-2-year']  value = 1 - Makif, 2 - Third party , 3 - No insurance
		//$insurance_params['insurance-3-year']  value = 1 - Makif, 2 - Third party , 3 - No insurance
		//Setup insurance past values for comparing conditions
		$insurance_past_sequence = $this->set_insurance_past( $insurance_params );

		if ( $insurance_params['insurance-before'] == '2' ) {
			$this->params['input']['CarDetails']['RetzefBituhi'] = 'ZERO';
		}

		//how much years was insurance before current insurance
		switch ( $insurance_past_sequence ) {
			case 1:
				$this->params['input']['CarDetails']['RetzefBituhi'] = 'ONE';
				break;
			case 2:
				$this->params['input']['CarDetails']['RetzefBituhi'] = 'TWO';
				break;
			case 3:
				$this->params['input']['CarDetails']['RetzefBituhi'] = 'THREE';
				break;
			case 0:
				$this->params['input']['CarDetails']['RetzefBituhi'] = 'ZERO';
				break;
		}

		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'AYALON ' );
			var_dump( $this->params );
			echo '</pre>';
		}

		try {
			$this->response = $this->soap->CarInsuranceCalculation( $this->params );
			if ( isset( $_GET['dev'] ) ) {
				echo "REQUEST:\n" . $this->soap->__getLastRequest() . "\n";
				var_dump( ' Results' );
				var_dump( $this->response );
				var_dump( 'AYALON END' );
				echo '</pre>++++++++++++++'; 
			}

		} catch ( SoapFault $e ) {
			if ( isset( $_GET['dev'] ) ) {
				echo "REQUEST SOAP:\n";
				var_dump( $this->soap->__getLastRequest() );
				var_dump( ' Results' );
				var_dump( $e );
				var_dump( 'AYALON END' );
				echo '</pre>++++++++++++++'; 
			}
//			var_dump($this->response);
//			echo "error";
//			var_dump($e->getMessage());
			//return false;
			return array();
		}

//		var_dump($this->response);
		//get relevant data from function params($ayalon etc...) & build the my_array according to my need
		$this->ayalon_array = array();

		$mandatory_price = $this->response->CarInsuranceCalculationResult->PremiumDetails->CompulsoryPremium;
		//Fix mandatory insurance price by day left in year
		$price_for_day = $mandatory_price / 365;
		$new_price     = $price_for_day * $days_left;


		$this->ayalon_array['mandatory']     = ceil( $new_price );
		$this->ayalon_array['comprehensive'] = $this->response->CarInsuranceCalculationResult->PremiumDetails->BrutoPremium;
		$this->ayalon_array['protect']       = $this->response->CarInsuranceCalculationResult->PremiumDetails->ReqProtectionDesc;
		$this->ayalon_array['protect_id']    = $this->response->CarInsuranceCalculationResult->PremiumDetails->ReqProtectionId;
		$this->ayalon_array['id']            = $this->company['company_id'];
//		$this->ayalon_array['company']       = 'ayalon';
		$this->ayalon_array['company']      = $this->company['mf_company_name'];
		$this->ayalon_array['company_id']   = $this->company['company_id'];
		$this->ayalon_array['company_slug'] = 'ayalon';

		return $this->ayalon_array;
	}
	
	public function calc_price4905( $insurance_params ) {
//		debug( $insurance_params );

//var_dump(is_null($insurance_params['levi-code']));
		if ( is_null( $insurance_params['levi-code'] ) ) {
			return false;
		}	
		
// אם הרכב מסחרי וגיל קטן מ 24 או וותק 0
		if ($insurance_params['levi-code'] > 999999 && ($insurance_params['youngest-driver'] < 24 || $insurance_params['lowest-seniority'] == 0)) {
			return false;
		}
// אם רכב פרטי והגיל קטן מ 21 או וותק 0
		if ($insurance_params['youngest-driver'] < 21 || $insurance_params['lowest-seniority'] == 0) {
			return false;
		}
		
// אם אין עבר ביטוחי בכלל או אם יש 2 תביעות
		if (((int)$insurance_params['insurance-1-year'] === 3) || ((int)$insurance_params['insurance-2-year'] === 3) || ((int)$insurance_params['insurance-before'] === 2) || ((int)$insurance_params['law-suites-3-year'] === 2)){
			return false;
    }
// אם אחת מהשנים היא לא מקיף - אבל יש תביעה
		if ((((int)$insurance_params['insurance-1-year'] !== 1) || ((int)$insurance_params['insurance-2-year'] !== 1) || ((int)$insurance_params['insurance-3-year'] !== 1)) && ((int)$insurance_params['law-suites-3-year'] !== 0)){
			return false;
    }	
		
// אם אחת מהשנים היא צד ג - ובנוסף אין תביעה אבל יש שנה נוספת ללא עבר ביטוחי		
		if ((((int)$insurance_params['insurance-1-year'] === 2) || ((int)$insurance_params['insurance-2-year'] === 2) || ((int)$insurance_params['insurance-3-year'] === 2)) && (((int)$insurance_params['law-suites-3-year'] === 0) && (((int)$insurance_params['insurance-1-year'] === 3) || ((int)$insurance_params['insurance-2-year'] === 3) || ((int)$insurance_params['insurance-3-year'] === 3) ))){
			return false;
    }
		
// ביטול השנה השלישית כשיש צד ג באחת מהשנים
		if ((((int)$insurance_params['insurance-1-year'] === 2) || ((int)$insurance_params['insurance-2-year'] === 2) || ((int)$insurance_params['insurance-3-year'] === 2)) && ((int)$insurance_params['law-suites-3-year'] === 0)){
			$zadgPast3 = 9;
			$rezefBit = "TWO";
    }	

//		//		echo '<pre style="direction: ltr;">';
//		var_dump($insurance_params);
//		echo '</pre>';
		$time_zone = new DateTimeZone( 'Asia/Jerusalem' );

		//setup start date ************
		$start                = str_replace( '/', '-', $insurance_params['insurance_period'] );
		$start_date           = new DateTime( $start, $time_zone );
		$start_date_formatted = $start_date->format( 'Y-m-d' );

		//setup end date ************
		$end                = str_replace( '/', '-', $insurance_params['insurance-date-finish'] );
		$end_date           = new DateTime( $end, $time_zone );
		$end_date_formatted = $end_date->format( 'Y-m-d' );

		//Days number for calc mandatory insurance price of days left in year
		$days_left = (int) $end_date->diff( $start_date )->format( "%a" ) + 1;

		//setup number of drivers *************
		$NumOfDrivers = '';
		switch ( $insurance_params['drive-allowed-number'] ) {
			case 1:
				$NumOfDrivers = 'ONE';
				break;
			case 2:
				$NumOfDrivers = 'ONE';
				break;
			default:
				$NumOfDrivers = 'ANY';
				break;
		}

		//setup youngest driver age *************
		$today        = new DateTime( 'now', $time_zone );
		$youngest_age = $today->modify( '-' . $insurance_params['youngest-driver'] . ' year' );


		//setup Rishayon Date *************
		$today2 = new DateTime( 'now', $time_zone );

		$r_date = $today2->modify( '-' . $insurance_params['lowest-seniority'] . ' year' );
		$r_date = $r_date->format( 'Y' ) . "-01-01T00:00:00";

//		echo '<pre style="direction: ltr;">';
//		var_dump($insurance_params);
//		echo '</pre>-------------------------------------------------------';
//		echo '-----------------------------------------------------';
//		var_dump($r_date);

		//remove all leading zeros from levi code
		$code_levi = ltrim( $insurance_params['levi-code'], '0' );

		//if code levi length is 7 its commercial vehicle type, else its private
		$vehicle_type_by_levi = strlen( $code_levi );

////sami count rezef bituhi years:
        
		if (((int)$insurance_params['insurance-1-year'] === 3) || ((int)$insurance_params['law-suite-what-year'] === 1))
		{
        $rezefCount1Year = 0;
		}
		else {
        $rezefCount1Year = 1;
		}
		if (((int)$insurance_params['insurance-2-year'] === 3) || ((int)$insurance_params['law-suite-what-year'] === 2))
		{
        $rezefCount2Year = 0;
		}
		else {
        $rezefCount2Year = 1;
		}
		if (((int)$insurance_params['insurance-3-year'] === 3) || ((int)$insurance_params['law-suite-what-year'] === 3))
		{
        $rezefCount3Year = 0;
		}
		else {
        $rezefCount3Year = 1;
		}
		$rezefCount = ($rezefCount1Year + $rezefCount2Year + $rezefCount3Year);
		if($rezefCount == 0)
		{
		$rezefBit = "ZERO";
		}
		if($rezefCount == 1)
		{
		$rezefBit = "ONE";
		}
		if($rezefCount == 2)
		{
		$rezefBit = "TWO";
		}			
		if($rezefCount == 3)
		{
		$rezefBit = "THREE";
		}
		if ($insurance_params['insurance-before'] === '2') {
			$rezefBit = "ZERO";
		}
		if ($zadgPast3 == 9)
		{
		$rezefBit = "TWO";
		}
		
		$this->params = array(
			'input' => array(
				"Anaf"               => "OTODIL",
				"CollectiveId"       => "905",
				"InsuranceStartDate" => $start_date_formatted . "T00:00:00",
				"InsuranceEndDate"   => $end_date_formatted . "T00:00:00",
				"AgentId"            => "520250",
				"Password"           => "CB791924-1BB9-4012-81E2-21A7BF57076E",

				"CarDetails" => array(
					'ManufactoreId' => '0',
					'CarType'          => $vehicle_type_by_levi != 7 ? 'PRIVATE' : 'COMMERCIAL',
					"Ownership"        => $insurance_params['ownership'] == '1' ? 'PRIVATE' : 'COMMERCIAL',
//					"CarLicense"       => 0, //not mandatory
//					"EngineVolume"     => 1798, //not mandatory
					"Year"             => (int) $insurance_params['vehicle-year'],
					"GearType"         => $insurance_params['gears'] == '1' ? 'MANUAL' : 'AUTOMATIC',
					"ESP"              => (int) $insurance_params['esp'] === 1 ? "YES" : "NO",
					"FCW"              => (int) $insurance_params['keeping-distance-system'] === 1 ?  "YES" : "NO",
					"LDW"              => (int) $insurance_params['deviation-system'] === 1 ?  "YES" : "NO",
					"ModelId"          => $insurance_params['levi-code'],
					//588300
//					"ManufactoreId"    => 2,
					"InsurenceCarType" => isset( $_GET['insurance-type'] ) && $_GET['insurance-type'] == 'ZAD_G' ? "ZAD_G" : "MAKIF",

					"MainDriverGender"           => $insurance_params['gender'] == '1' ? 'MALE' : 'FEMALE',
					"NumOfDrivers"               => $NumOfDrivers,
					//setup above in the beginning of the function
					"YoungestDriverAge"          => (int) $insurance_params['youngest-driver'],
					"YoungestBirthdate"          => $youngest_age->format( 'Y-m-d' ) . "T00:00:00",
					//"YoungestDriverRishayonDate" => $r_date->format( 'Y-m-d' ) . "T00:00:00",
					"YoungestDriverRishayonDate" => $r_date,
					"OldestDriverAge"            => 80,
					"RishayonDate"               => "$r_date",
					//"2005-01-01T00:00:00",
					"Revocations"                => isset( $insurance_params['license-suspensions'] ) ? (int) $insurance_params['license-suspensions'] : 0,
					"PersonalinjuryClaims"       => isset( $insurance_params['body-claims'] ) ? (int) $insurance_params['body-claims'] : 0,
					"VetekNehiga"                => (int) $insurance_params['lowest-seniority'] >= 1 ? "NO" : "YES",

					"Grira"           => "NO",
					"Shmashot"        => "NO",
					"Halifi"          => "NO",
					"IsDriveOnShabat" => ( (int) $insurance_params['drive-on-saturday'] === 1 ?  "YES" : "NO" ),
					"Vip"             => "NONE",
					'HovaHofef'       => "YES",
					//"hanachatHatama" => 25,
					//"hanachatSochen" => 20,
					//"PREMIA_KITUM"   => 5.500,
//					"numOfClaims"     => isset( $insurance_params['law-suites-3-year'] ) ? (int)$insurance_params['law-suites-3-year'] : 0,
					"RetzefBituhi"    => $rezefBit,
					'PanasimMaraot'   => "NO",
					'Earthquake'   => "NO",
					'RiotsStrikes'   => "NO",
					'ZechutNigrar'   => "NO",
					'NewOld'   => 0,
					'HanachatSochen'   => 0,
					'SapakHavilaAlifim'   => 0,
					'SheverShmashotAdHabait'   => "NO",

					"cliamsHistoryCarLast3Years" =>
						array(
							array(
								"NumOfCarClaims"   => isset( $insurance_params['law-suite-what-year'] ) && $insurance_params['law-suite-what-year'] == '1' ? 1 : 0,
								"InsuranceCompany" => isset( $insurance_params['insurance-1-year'] ) && $insurance_params['insurance-1-year'] !== '3' ? 1 : 9,
								"numOfYearsBefore" => 1
							),
							array(
								"NumOfCarClaims"   => isset( $insurance_params['law-suite-what-year'] ) && $insurance_params['law-suite-what-year'] == '2' ? 1 : 0,
								"InsuranceCompany" => isset( $insurance_params['insurance-2-year'] ) && $insurance_params['insurance-2-year'] !== '3' ? 1 : 9,
								"numOfYearsBefore" => 2
							),
							array(
								"NumOfCarClaims"   => isset( $insurance_params['law-suite-what-year'] ) && $insurance_params['law-suite-what-year'] == '3' ? 1 : 0,
								"InsuranceCompany" => $zadgPast3 == '9' ? 9 : (isset( $insurance_params['insurance-3-year'] ) && $insurance_params['insurance-3-year'] == '1' ? 1 : 9),
								"numOfYearsBefore" => $zadgPast3 == '9' ? 9 : (isset( $insurance_params['insurance-3-year'] ) && $insurance_params['insurance-3-year'] !== '1' ? 0 : 3),
							),

						),

				)
			)

		);


		//verify if was insurance before period
		//$insurance_params['insurance-1-year']  value = 1 - Makif, 2 - Third party , 3 - No insurance
		//$insurance_params['insurance-2-year']  value = 1 - Makif, 2 - Third party , 3 - No insurance
		//$insurance_params['insurance-3-year']  value = 1 - Makif, 2 - Third party , 3 - No insurance
		//Setup insurance past values for comparing conditions
		$insurance_past_sequence = $this->set_insurance_past( $insurance_params );

		if ( isset( $_GET['dev'] ) ) {
			echo '<pre style="direction: ltr;">';
			var_dump( 'AYALON ' );
			var_dump( $this->params );
			echo '</pre>';
		}

		try {
			$this->response = $this->soap->CarInsuranceCalculation( $this->params );
			if ( isset( $_GET['dev'] ) ) {
				echo "REQUEST:\n" . $this->soap->__getLastRequest() . "\n";
				var_dump( ' Results' );
				var_dump( $this->response );
				var_dump( 'AYALON END' );
				echo '</pre>++++++++++++++'; 
			}

		} catch ( SoapFault $e ) {
			if ( isset( $_GET['dev'] ) ) {
				echo "REQUEST SOAP:\n";
				var_dump( $this->soap->__getLastRequest() );
				var_dump( ' Results' );
				var_dump( $e );
				var_dump( 'AYALON END' );
				echo '</pre>++++++++++++++'; 
			}
//			var_dump($this->response);
//			echo "error";
//			var_dump($e->getMessage());
			//return false;
			return array();
		}

//		var_dump($this->response);
		//get relevant data from function params($ayalon etc...) & build the my_array according to my need
		$this->ayalon_array = array();

		$mandatory_price = $this->response->CarInsuranceCalculationResult->PremiumDetails->CompulsoryPremium;
		//Fix mandatory insurance price by day left in year
		$price_for_day = $mandatory_price / 365;
		$new_price     = $price_for_day * $days_left;
		//Fix Makif whitout DMEY ASHRAY
		$comprehensive_price = $this->response->CarInsuranceCalculationResult->PremiumDetails->BrutoPremium;
//		$newcomprehensiveprice = ($comprehensive_price * $0.979);

		$this->ayalon_array['mandatory']     = ceil( $new_price );
		$this->ayalon_array['comprehensive'] = ceil( $comprehensive_price * 0.979 );
		$this->ayalon_array['protect']       = $this->response->CarInsuranceCalculationResult->PremiumDetails->ReqProtectionDesc;
		$this->ayalon_array['protect_id']    = $this->response->CarInsuranceCalculationResult->PremiumDetails->ReqProtectionId;
		$this->ayalon_array['id']            = $this->company['company_id'];
//		$this->ayalon_array['company']       = 'ayalon';
		$this->ayalon_array['company']      = $this->company['mf_company_name'];
		$this->ayalon_array['company_id']   = $this->company['company_id'];
		$this->ayalon_array['company_slug'] = 'ayalon';

		return $this->ayalon_array;
	}
	public function fix_insurance_past_value( $value ) {
		if ( $value === 2 ) {
			$value = 0.5;
		} else if ( $value === 3 ) {
			$value = 0;
		}

		return $value;
	}

	public function set_insurance_past( $insurance_params ) {

		$ins_past_arr = [];
		$ins_sequence = 0;
		//setup requirements
		$ins_past_arr['insurance_before_year']        = $this->fix_insurance_past_value( (int) $insurance_params['insurance-1-year'] );
		$ins_past_arr['insurance_before_two_years']   = $this->fix_insurance_past_value( (int) $insurance_params['insurance-2-year'] );
		$ins_past_arr['insurance_before_three_years'] = $this->fix_insurance_past_value( (int) $insurance_params['insurance-3-year'] );
		$law_suits_lats_three_years                   = (int) $insurance_params['law-suites-3-year'];

		foreach ( $ins_past_arr as $ins_past ) {
			$ins_sequence += $ins_past;
		}

		$ins_sequence = floor( $ins_sequence );

		if ( $law_suits_lats_three_years === 1 ) {
			$ins_sequence --;
		}

		return $ins_sequence;
	}
}
