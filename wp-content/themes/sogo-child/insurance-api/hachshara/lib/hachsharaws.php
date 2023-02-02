<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 13/12/2017
 * Time: 9:18 AM
 */

class hachsharaws {
	private $api_url;
	private $params;
	private $soap;
	private $xml_obj;
	private $response;
	private $hachshara_array;
	private $hachshara_array_2;
	private $hachshara_array_3;
	private $insurance_type;
	private $company;

	//rest


	public function __construct($company, $type) {
//		$this->api_url = "https://wsproxy.hcsra.co.il/ProxyServices/CarOfferService.svc/GetCarOffer?";
		$this->api_url = "https://wsproxy.hcsra.co.il/ProxyServices/api/CarOfferAPI/GetCarOffer"; //REST
//		$this->api_url = "https://wsproxy.hcsra.co.il/ProxyServices/CarOfferService.svc?singleWsdl";
		//$this->api_url = "https://wsproxy.hcsra.co.il/ProxyServices/CarOfferService.svc?wsdl"; //SOAP

		$options = array(
			'cache_wsdl'     => 0,
			'trace'          => 1,
			'stream_context' => stream_context_create( array(
				'ssl' => array(
					'verify_peer'       => false,
					'verify_peer_name'  => false,
					'allow_self_signed' => true
				)
			) )
		);

		$this->company = $company;
		$this->insurance_type = $type;

//		$this->soap = new SoapClient( $this->api_url, $options );
	}


	public function calc_price( $insurance_params ) {

		if(is_null($insurance_params['levi-code'])){

			return false;
		}
		if ((int)$insurance_params['law-suites-3-year'] === 2) {
			return false;
		}
		$time_zone = new DateTimeZone( 'Asia/Jerusalem' );

		//setup start date ***********
		$start = str_replace( '/', '-', $insurance_params['insurance_period'] );

		$start_time = new DateTime( $start, $time_zone );
		$start_date = $start_time->format( 'd/m/Y' );

		//setup Rishayon Date *************
		$today2 = new DateTime( 'now', $time_zone );

		$r_date = $today2->modify( '-' . $insurance_params['lowest-seniority'] . ' year' );
//		$r_date = $r_date->format( 'Y' ) . "-01-01T00:00:00";
		$r_date = $r_date->format( 'mY' );

		$NumOfDrivers = '';
		switch ( $insurance_params['drive-allowed-number'] ) {
			case 1:
				$NumOfDrivers = 1;
				break;
			case 2:
				$NumOfDrivers = 2;
				break;
			case 3:
			case 4:
				$NumOfDrivers = 9;
				break;
		}

		//fix law suits count
		$suits_first_year  = 0;
		$suits_second_year = 0;
		$suits_third_year  = 0;
		if ((int)$insurance_params['law-suites-3-year'] === 1) {

			switch ((int)$insurance_params['law-suite-what-year']) {
				case 1 :
					$suits_first_year  = 1;
					break;
				case 2 :

					$suits_second_year = 1;
					break;
				case 3 :
					$suits_third_year  = 1;
					break;
			}
		}


		$this->params = array(
			'JointDiscount' => 20,
			'AgentId'       => '111900',

			'insuranceDetails' => array(
				'FromDate'         => $start_date,
				'ModelNumber'      => $insurance_params['levi-code'],//481223
				'ProduceYear'      => (int) $insurance_params['vehicle-year'],
				'SugEmtzaiTashlum' => 3,
				'LicenseNumber'    => $insurance_params['license_no'],
			),

			'DriversDetails' => array(
				'Drivers'                   => $NumOfDrivers,
				'DriverYoungestAge'         => (int) $insurance_params['youngest-driver'],
				'DriverYoungestLicenseYear' => $r_date,//nee to put only month and year without slash here (for example: 062012. 06 - month, 2012 - year)
//				'DriverYoungestLicenseYear' => '062012',
				'CoverForNewDriver'         => $insurance_params['lowest-seniority'] == '0' ? true : false,
				'IsPrivateOwner'            => $insurance_params['ownership'] == '1' ? true : false,
				'DriveInSat'                => true,
				'ZipCode'                   => 4442510,
				'YoungestDriverGender'      => $insurance_params['gender'] == '1' ? 1 : 2
			),

			'insurancePass' => array(
				'TypeOfInsuranceYearBefore'       => ($insurance_params['insurance-1-year'] == 3) || ($insurance_params['insurance-before'] == 2) ? 0 : 2,
				'TypeOfInsuranceTwoYearsBefore'   => ($insurance_params['insurance-2-year'] == 3) || ($insurance_params['insurance-before'] == 2) ? 0 : 2,
				'TypeOfInsuranceThreeYearsBefore' => ($insurance_params['insurance-3-year'] == 3) || ($insurance_params['insurance-before'] == 2) ? 0 : 2,

				//'NumberOfClaimYearBefore'      => 0,
				'NumberOfClaimYearBefore'      => $suits_first_year,
				//'NumberOfClaimTwoYearsBefore'  => 0,
				'NumberOfClaimTwoYearsBefore'  => $suits_second_year,
				//'NumberOfClaimThreeYearBefore' => 0,
				'NumberOfClaimThreeYearBefore' => $suits_third_year,

				'NumberOfTimesLicenseSuspended'     => $insurance_params['license-suspensions'] == '3' ? 1 : (int) $insurance_params['license-suspensions'],
				'NumberOfBodyDamagesLastThreeYears' => $insurance_params['body-claims'],

				'DeductibleInCase' => 2,
				'CancelDeductible' => 2
			)
		);
//		echo '<pre style="direction: ltr;">';
//		var_dump($this->params);
//		echo '</pre>';
		//json
		if (isset($_GET['dev'])) {
			echo '<pre style="direction: ltr;">';
			var_dump((int)$insurance_params['body-claims']);
			echo '</pre>';
			echo '<pre style="direction: ltr;">+++++++++++++';
			var_dump('HACHSHARA');
			var_dump( $this->params);


		}
		$data_string = json_encode( $this->params );
		$ch = curl_init( $this->api_url );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_string );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen( $data_string )
		) );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 6);

		try {
			$result = curl_exec( $ch );
//			echo '<pre style="direction: ltr;">';
//			var_dump($result);
//			echo '</pre>';
			if (!curl_errno($ch)) {
				$info = curl_getinfo($ch);
			}

		} catch(Exception $e) {
			echo $e->getMessage();
		}

		//close connections
		curl_close( $ch );

		//setup the arrays
		$this->hachshara_array   = array();
		$this->hachshara_array_2 = array();
		$this->hachshara_array_3 = array();
		$result                  = json_decode( $result, true );
		if (isset($_GET['dev'])) {
			var_dump('HACHSHARA Results');
			var_dump( $result);
			var_dump('HACHSHARA END');
			echo '</pre>++++++++++++++';
		}

		//populate the arrays
		$mandatory             = false;
		$comprehensive         = false;
		$comprehensive_perfect = false;
		$zad_g                 = false;

		foreach ((array) $result['Value']['LstOffers'] as $array ) {
			if ( $array['Anaf'] == '60' ) {
				$comprehensive = true;
			}

			if ( $array['Anaf'] == '66' ) {
				$zad_g = true;
			}

			if ( $array['Anaf'] == '80' ) {
				$mandatory = true;
			}

			if ( $array['Anaf'] == '74' ) {
				$comprehensive_perfect = true;
			}
		}

		if($this->insurance_type == 'MAKIF'){
			if ( $comprehensive && $mandatory ) {

				$this->hachshara_array['mandatory']     = $result['Value']['LstOffers'][1]['Price'];
				$this->hachshara_array['comprehensive'] = $result['Value']['LstOffers'][0]['Price'];
				$this->hachshara_array['protect']       = '';
				$this->hachshara_array['protect_id']    = $result['Value']['LstOffers'][0]['CodeMigun'];
				$this->hachshara_array['id']            = $this->company['company_id'];
				$this->hachshara_array['company']       = $this->company['mf_company_name'];
				$this->hachshara_array['company_id']    = $this->company['company_id'];
				$this->hachshara_array['company_slug']    = 'hachshara';
				{
				if	($result['Value']['LstOffers'][0]['Price'] == (0 || ''))
				return false;
				}			}
		}

		if($this->insurance_type == 'ZAD_G'){
			if ( $zad_g && $mandatory ) {
				$this->hachshara_array['mandatory']     = $result['Value']['LstOffers'][1]['Price'];
				$this->hachshara_array['comprehensive'] = $result['Value']['LstOffers'][3]['Price'];
				$this->hachshara_array['protect']       = '';
				$this->hachshara_array['protect_id']    = $result['Value']['LstOffers'][3]['CodeMigun'];
				$this->hachshara_array['id']            = $this->company['company_id'];
//			$this->hachshara_array_3['company']       = 'hachshara';
				$this->hachshara_array['company']    = $this->company['mf_company_name'];
				$this->hachshara_array['company_id'] = $this->company['company_id'];
				$this->hachshara_array['company_slug']    = 'hachshara';
			}
		}


		/*if ( $comprehensive_perfect && $mandatory ) {
			$this->hachshara_array_2['mandatory']     = $result['Value']['LstOffers'][1]['Price'];
			$this->hachshara_array_2['comprehensive'] = $result['Value']['LstOffers'][2]['Price'];
			$this->hachshara_array_2['protect']       = '';
			$this->hachshara_array_2['protect_id']    = $result['Value']['LstOffers'][2]['CodeMigun'];
			$this->hachshara_array_2['id']            = $this->company['company_id'];
			$this->hachshara_array_2['company']       = $this->company['mf_company_name'];
			$this->hachshara_array_2['company_id']    = $this->company['company_id'];
			$this->hachshara_array_2['company_slug']    = 'hachshara';
		}*/

//		return array( $this->hachshara_array, $this->hachshara_array_2, $this->hachshara_array_3 );
		return $this->hachshara_array;
	}

	


	public function calc_price_bestCarPlus( $insurance_params ) {

		if(is_null($insurance_params['levi-code'])){

			return false;
		}
		if ((int)$insurance_params['law-suites-3-year'] === 2) {
			return false;
		}
		$time_zone = new DateTimeZone( 'Asia/Jerusalem' );

		//setup start date ***********
		$start = str_replace( '/', '-', $insurance_params['insurance_period'] );

		$start_time = new DateTime( $start, $time_zone );
		$start_date = $start_time->format( 'd/m/Y' );

		//setup Rishayon Date *************
		$today2 = new DateTime( 'now', $time_zone );

		$r_date = $today2->modify( '-' . $insurance_params['lowest-seniority'] . ' year' );
//		$r_date = $r_date->format( 'Y' ) . "-01-01T00:00:00";
		$r_date = $r_date->format( 'mY' );

		$NumOfDrivers = '';
		switch ( $insurance_params['drive-allowed-number'] ) {
			case 1:
				$NumOfDrivers = 1;
				break;
			case 2:
				$NumOfDrivers = 2;
				break;
			case 3:
			case 4:
				$NumOfDrivers = 9;
				break;
		}

		//fix law suits count
		$suits_first_year  = 0;
		$suits_second_year = 0;
		$suits_third_year  = 0;
		if ((int)$insurance_params['law-suites-3-year'] === 1) {

			switch ((int)$insurance_params['law-suite-what-year']) {
				case 1 :
					$suits_first_year  = 1;
					break;
				case 2 :

					$suits_second_year = 1;
					break;
				case 3 :
					$suits_third_year  = 1;
					break;
			}
		}

		//sami - when ONE YEAR HISTORY IS ZAD GIMEL IT COUNTS FOR HACHSHARA LIKE TWO YEARS MAKIF WITHOUT CLAIMS - 26.6.2022 still at work
//		if (((int)$insurance_params['law-suites-3-year'] === 0) && (((int)$insurance_params['insurance-1-year'] === 2) || ((int)$insurance_params['insurance-2-year'] === 2) || //((int)$insurance_params['insurance-3-year'] === 3)) {
//$samiYear3 = 0;
//		}
		
		$this->params = array(
			'JointDiscount' => 20,
			'AgentId'       => '111900',

			'insuranceDetails' => array(
				'FromDate'         => $start_date,
				'ModelNumber'      => $insurance_params['levi-code'],//481223
				'ProduceYear'      => (int) $insurance_params['vehicle-year'],
				'SugEmtzaiTashlum' => 3,
				'LicenseNumber'    => $insurance_params['license_no'],
			),

			'DriversDetails' => array(
				'Drivers'                   => $NumOfDrivers,
				'DriverYoungestAge'         => (int) $insurance_params['youngest-driver'],
				'DriverYoungestLicenseYear' => $r_date,//nee to put only month and year without slash here (for example: 062012. 06 - month, 2012 - year)
//				'DriverYoungestLicenseYear' => '062012',
				'CoverForNewDriver'         => $insurance_params['lowest-seniority'] == '0' ? true : false,
				'IsPrivateOwner'            => $insurance_params['ownership'] == '1' ? true : false,
				'DriveInSat'                => true,
//				'ZipCode'                   => 4442510,
//				'YoungestDriverGender'      => $insurance_params['gender'] == '1' ? 1 : 2
  				'YoungestDriverGender'      => 1

			),

			'insurancePass' => array(
				'TypeOfInsuranceYearBefore'       => ($insurance_params['insurance-1-year'] == 3) || ($insurance_params['insurance-before'] == 2) ? 0 : 2,
				'TypeOfInsuranceTwoYearsBefore'   => ($insurance_params['insurance-2-year'] == 3) || ($insurance_params['insurance-before'] == 2) ? 0 : 2,
				'TypeOfInsuranceThreeYearsBefore' => ($insurance_params['insurance-3-year'] == 3) || ($insurance_params['insurance-before'] == 2) ? 0 : 2,

				//'NumberOfClaimYearBefore'      => 0,
				'NumberOfClaimYearBefore'      => $suits_first_year,
				//'NumberOfClaimTwoYearsBefore'  => 0,
				'NumberOfClaimTwoYearsBefore'  => $suits_second_year,
				//'NumberOfClaimThreeYearBefore' => 0,
				'NumberOfClaimThreeYearBefore' => $suits_third_year,

				'NumberOfTimesLicenseSuspended'     => $insurance_params['license-suspensions'] == '3' ? 1 : (int) $insurance_params['license-suspensions'],
				'NumberOfBodyDamagesLastThreeYears' => $insurance_params['body-claims'],

				'DeductibleInCase' => 2,
				'CancelDeductible' => 2
			)
		);
//		echo '<pre style="direction: ltr;">';
//		var_dump($this->params);
//		echo '</pre>';
		//json
		if (isset($_GET['dev'])) {
			echo '<pre style="direction: ltr;">';
			var_dump((int)$insurance_params['body-claims']);
			echo '</pre>';
			echo '<pre style="direction: ltr;">+++++++++++++';
			var_dump('HACHSHARA');
			var_dump( $this->params);


		}
		$data_string = json_encode( $this->params );
		$ch = curl_init( $this->api_url );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'POST' );
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_string );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen( $data_string )
		) );
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
		curl_setopt($ch, CURLOPT_TIMEOUT, 6);

		try {
			$result = curl_exec( $ch );
//			echo '<pre style="direction: ltr;">';
//			var_dump($result);
//			echo '</pre>';
			if (!curl_errno($ch)) {
				$info = curl_getinfo($ch);
			}

		} catch(Exception $e) {
			echo $e->getMessage();
		}

		//close connections
		curl_close( $ch );

		//setup the arrays
		$this->hachshara_array   = array();
		$this->hachshara_array_2 = array();
		$this->hachshara_array_3 = array();
		$result                  = json_decode( $result, true );
		if (isset($_GET['dev'])) {
			var_dump('HACHSHARA Results');
			var_dump( $result);
			var_dump('HACHSHARA END');
			echo '</pre>++++++++++++++';
		}

		//populate the arrays
		$mandatory             = false;
		$comprehensive         = false;
		$comprehensive_perfect = false;
		$zad_g                 = false;

		foreach ((array) $result['Value']['LstOffers'] as $array ) {
			if ( $array['Anaf'] == '742' ) {
				$comprehensive = true;
			}

			if ( $array['Anaf'] == '66' ) {
				$zad_g = true;
			}

			if ( $array['Anaf'] == '80' ) {
				$mandatory = true;
			}

			if ( $array['Anaf'] == '74' ) {
				$comprehensive_perfect = true;
			}			
		}

		if($this->insurance_type == 'MAKIF'){
			if ( $comprehensive && $mandatory ) {

				$this->hachshara_array['mandatory']     = $result['Value']['LstOffers'][1]['Price'];
				$this->hachshara_array['comprehensive'] = $result['Value']['LstOffers'][5]['Price'];
				$this->hachshara_array['protect']       = '';
				$this->hachshara_array['protect_id']    = $result['Value']['LstOffers'][5]['CodeMigun'];
				$this->hachshara_array['id']            = $this->company['company_id'];
				$this->hachshara_array['company']       = $this->company['mf_company_name'];
				$this->hachshara_array['company_id']    = $this->company['company_id'];
				$this->hachshara_array['company_slug']    = 'hachshara';
				{
				if	($result['Value']['LstOffers'][0]['Price'] == (0 || ''))
				return false;
				}			}
		}

		if($this->insurance_type == 'ZAD_G'){
			if ( $zad_g && $mandatory ) {
				$this->hachshara_array['mandatory']     = $result['Value']['LstOffers'][1]['Price'];
				$this->hachshara_array['comprehensive'] = $result['Value']['LstOffers'][3]['Price'];
				$this->hachshara_array['protect']       = '';
				$this->hachshara_array['protect_id']    = $result['Value']['LstOffers'][3]['CodeMigun'];
				$this->hachshara_array['id']            = $this->company['company_id'];
//			$this->hachshara_array_3['company']       = 'hachshara';
				$this->hachshara_array['company']    = $this->company['mf_company_name'];
				$this->hachshara_array['company_id'] = $this->company['company_id'];
				$this->hachshara_array['company_slug']    = 'hachshara';
			}
		}


		/*if ( $comprehensive_perfect && $mandatory ) {
			$this->hachshara_array_2['mandatory']     = $result['Value']['LstOffers'][1]['Price'];
			$this->hachshara_array_2['comprehensive'] = $result['Value']['LstOffers'][2]['Price'];
			$this->hachshara_array_2['protect']       = '';
			$this->hachshara_array_2['protect_id']    = $result['Value']['LstOffers'][2]['CodeMigun'];
			$this->hachshara_array_2['id']            = $this->company['company_id'];
			$this->hachshara_array_2['company']       = $this->company['mf_company_name'];
			$this->hachshara_array_2['company_id']    = $this->company['company_id'];
			$this->hachshara_array_2['company_slug']    = 'hachshara';
		}*/

//		return array( $this->hachshara_array, $this->hachshara_array_2, $this->hachshara_array_3 );
		return $this->hachshara_array;
	}
}